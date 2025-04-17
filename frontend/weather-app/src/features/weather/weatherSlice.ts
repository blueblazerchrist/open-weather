import { createSlice, createAsyncThunk } from '@reduxjs/toolkit'
import { WeatherState } from './types'
import {getCurrentWeather, getForecast} from "../../services/weatherApi.ts";

const initialState: WeatherState = {
  loading: false,
  current: null,
  forecast: [],
  error: null,
}

export const fetchCurrentWeather = createAsyncThunk(
  'weather/fetchCurrent',
  async (location: string) => {
    return await getCurrentWeather(location)
  }
)

export const fetchForecast = createAsyncThunk(
  'weather/fetchForecast',
  async ({ location, days }: { location: string, days: number }) => {
    return await getForecast(location, days)
  }
)

const weatherSlice = createSlice({
  name: 'weather',
  initialState,
  reducers: {
    clearError: (state) => {
      state.error = null
    }
  },
  extraReducers: (builder) => {
    builder
      .addCase(fetchCurrentWeather.pending, (state) => {
        state.loading = true
        state.error = null
      })
      .addCase(fetchCurrentWeather.fulfilled, (state, action) => {
        state.loading = false
        state.current = action.payload
      })
      .addCase(fetchCurrentWeather.rejected, (state, action) => {
        state.loading = false
        state.error = action.error.message || 'Error al obtener el clima actual.'
      })
      .addCase(fetchForecast.rejected, (state, action) => {
        state.loading = false
        state.error = action.error.message || 'Error al obtener la previsión.'
      })
      .addCase(fetchForecast.fulfilled, (state, action) => {
        state.forecast = action.payload.forecast
      })
  }
})

export const { clearError } = weatherSlice.actions

export default weatherSlice.reducer
