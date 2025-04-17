import axios from 'axios'
import { WeatherResponse, ForecastResponse } from '../features/weather/types'

const API_BASE = 'http://api.open-weather.test/api/weather'

export const getCurrentWeather = async (location: string): Promise<WeatherResponse> => {
  const res = await axios.post(`${API_BASE}/current`, { location })
  return res.data
}

export const getForecast = async (location: string, days: number): Promise<ForecastResponse> => {
  const res = await axios.post(`${API_BASE}/forecast`, { location, days })
  return res.data
}
