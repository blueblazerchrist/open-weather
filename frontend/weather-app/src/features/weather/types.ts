export interface WeatherResponse {
  city: string
  date: string
  weather: string
  temperature: string
  icon: string
}

export interface ForecastDay {
  date: string
  weather: string
  temperature: string
  icon: string
}

export interface ForecastResponse {
  city: string
  forecast: ForecastDay[]
}

export interface WeatherState {
  loading: boolean
  current: WeatherResponse | null
  forecast: ForecastDay[]
  error: string | null
}
