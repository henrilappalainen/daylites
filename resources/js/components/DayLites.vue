<template>
  <div class="container">
    <h1>Valoaika</h1>
    <p>Vertaile päivän pituuksia Suomessa. Kirjoita kaupungin nimi, jonka haluat vertailuun.
    <form
      class="add-city-form"
      v-on:submit="getCityData">
      <label for="new-city-name">Lisää kaupunki</label>
      <input id="new-city-name" v-model="inp_name" />
      <button>Lisää</button>
    </form>


    <div v-if="cities" class="content">
      <div v-if="loading" class="loading">
        Loading...
      </div>

      <div v-if="error" class="error">
        {{ error }}
      </div>
      <div class="chart-container">
        <svg viewBox="0 0 1040 640" class="daylite-chart" >
          <rect width="1000" height="600" rx=6 fill="#fff" />
          <text 
            v-for="(num, i) in [0,2,4,6,8,10,12,14,16,18,20,22,24]"
            x="1003" 
            :y="584/12*(12-i)+16"
            :key="'ver'+i"
            fill="#555"
            >{{num}}</text>
          <text class="graph-desc-vertical" text-anchor="start" y="-1030" x="4" fill="#888">Päivänvalo tunteina</text>
          <text 
            v-for="(x, i) in new Array(12)"
            :x="900/11*i+40" 
            y="620"
            :key="'hor'+i"
            fill="#555"
            >{{i+1}}</text>
          <text x="460" y="640" fill="#888">Kuukaudet</text>
          <g
            v-for="(city, index) in cities" 
            :key="index">
            <circle
              v-for="(day, index) in city.values" 
              :key="index"
              :cx="index * 1000/365" 
              :cy="(24 - day) * 600 / 24"
              v-on:mouseover="setPophours(day, index)"
              v-on:mouseleave="clearPophours"
              :style="'fill:' + city.color + ';'"
              r="2"></circle>
          </g>
          <text v-if="pophours" :x="this.pophours.x" :y="this.pophours.y">
            {{this.pophours.daylength}}
          </text>
        </svg>
      </div>
      <div class="daylite-description">
        <div 
          v-for="(city, index) in cities"
          :key="index">
          <span 
            class="daylite-description__color"
            :style="'background-color:' + city.color + ';'"></span>
          {{city.name}}
          <button v-bind:data-name="city.name" v-on:click="removeItem">poista</button>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import colorlist from '../utility/colorlist'

export default {
  data () {
    return {
      loading: false,
      cities: [],
      inp_name: '',
      error: null,
      pophours: null
    }
  },
  created () {
    // For testing, fetch data on page load
    // this.fetchData('Helsinki', 60)
  },
  methods: {
    fetchData ( cityname, latitude ) {
      this.error = null
      this.loading = true
      // const fetchedId = this.$route.params.id
      axios.get('https://localhost:8000/api/daylites?latitude=' + latitude)
        .then(response => {
          const color = '#' + colorlist[this.cities.length]

          this.cities.push({name: cityname, values: response.data.daylites, color: color})

          this.loading = false
        })
        .catch(error => {
          console.log('error:', error);
          this.error = 'error occurred'
          this.loading = false
        })
    },
    getCityData (e) {
      e.preventDefault()

      let latitude
      let cityname

      axios.get('https://secure.geonames.org/searchJSON', {
        params: {
          name: this.inp_name,
          maxRows: 1,
          username: 'lappalainen'
      }})
        .then(response => {
          const data = response.data.geonames[0]

          if (data.name.toLowerCase() === this.inp_name.toLowerCase()) {
            latitude = data.lat
            cityname = data.name
          } else {
            this.error = 'Kaupunkia ei löytynyt!'

            return false
          }

          this.inp_name = ''

          this.fetchData( cityname, latitude )
        })
        .catch(error => {
          console.log(error)

          this.error = 'City not found!'
          return false
        })
    },
    setPophours (day, index) {
      const roundedDay = Math.round(day * 10) / 10
      this.pophours = {
        daylength: roundedDay,
        x: index * 1000/365 - 10,
        y: (24 - day) * 600 / 24 - 30
      }
    },
    clearPophours () {
      this.pophours = null
    },
    removeItem (e) {
      let cityname = e.target.dataset.name
      
      this.cities = this.cities.filter((city) => {
        if (city.name === cityname) return false

        return true
      })
    }
  }
}
</script>

<style scoped>
  .chart-container {
    width: 1040px;
    max-width: 100%;
    margin: auto;
  }
  .daylite-chart {
    width: 100%;
  }
  text.graph-desc-vertical {
    transform: rotate(90deg);
  }
</style>
