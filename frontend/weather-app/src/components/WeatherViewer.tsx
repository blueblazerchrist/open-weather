import { useState } from 'react'
import { useAppDispatch, useAppSelector } from '../app/hooks'
import { fetchCurrentWeather, fetchForecast } from '../features/weather/weatherSlice'

const WeatherViewer = () => {
  const dispatch = useAppDispatch()
  const { current, forecast, loading, error } = useAppSelector(state => state.weather)

  const [location, setLocation] = useState('')
  const [days, setDays] = useState(3)

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault()
    if (location.trim() === '') return

    dispatch(fetchCurrentWeather(location))
    dispatch(fetchForecast({ location, days }))
  }

  return (
    <div className="p-4 max-w-xl mx-auto">
      <form onSubmit={handleSubmit} className="bg-white p-4 rounded-md shadow-md mb-6">
        <div className="mb-4">
          <label className="block text-sm font-medium text-gray-700 mb-1">Ciudad + Código País</label>
          <input
            type="text"
            className="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Ej: MadridES"
            value={location}
            onChange={(e) => setLocation(e.target.value)}
            required
          />
        </div>
        <div className="mb-4">
          <label className="block text-sm font-medium text-gray-700 mb-1">Días de previsión (1-5)</label>
          <input
            type="number"
            min={1}
            max={5}
            className="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            value={days}
            onChange={(e) => setDays(Number(e.target.value))}
          />
        </div>
        <button
          type="submit"
          className="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-200 text-sm"
        >
          Consultar clima
        </button>
      </form>

      {loading && <p className="text-blue-600 text-center mb-4">Cargando...</p>}

      {error && (
        <div className="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded-md text-sm">
          <p><strong>Error:</strong> {error}</p>
        </div>
      )}

      {current && (
        <div className="mb-6 p-4 bg-blue-300 rounded-md shadow-md text-center">
          <h2 className="text-lg font-bold">{current.city}</h2>
          <p className="text-sm">{current.date}</p>
          <img
            src={current.icon}
            alt={current.weather}
            className="w-14 h-14 mx-auto my-2"
          />
          <p className="capitalize">{current.weather}</p>
          <p className="text-lg">{current.temperature}</p>
        </div>
      )}

      {forecast.length > 0 && (
        <div>
          <h3 className="text-base font-semibold mb-2 text-center">Pronóstico</h3>
          <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
            {forecast.map((f, idx) => (
              <div key={idx} className="p-4 bg-gray-300 rounded-md shadow text-center">
                <p className="text-sm">{f.date}</p>
                <img src={f.icon} alt={f.weather} className="w-12 h-12 mx-auto my-2"/>
                <p className="capitalize text-sm">{f.weather}</p>
                <p className="text-md font-medium">{f.temperature}</p>
              </div>
            ))}
          </div>
        </div>
      )}
    </div>

  )
}

export default WeatherViewer
