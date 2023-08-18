<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            'Weather App'
        </h2>
    </x-slot>

    <div class="py-12 text-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                <div x-data="weather()" x-init="getWeather()" class="p-6 bg-sky-500/100 border-5 border-gray-200">
                    <div x-text="weather.name" class="text-4xl mb-5"></div>

                    <div class="flex items-center max-w-[30%]">
                        <select x-model="city" @change="getWeather()" class="inline-block bg-sky-500/100">
                            @foreach(config('app.cities') as $key => $value)
                                <option value="{{ $key }}">{{ trans($key) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-center items-center">
                        <img :src="weather.icon" class="w-auto max-w-[30%]"/>
                        <span x-text="weather.temp" class="text-6xl"></span><span class="text-6xl">&#176;</span>
                    </div>
                    <div class="flex justify-center">
                        <p x-text="weather.description" class="-mt-5 text-xl mb-5"></p>
                    </div>
                    <div class="flex flex-row">
                        <div class="basis-1/4 sm:basis-1/2">
                            <p>Ветер</p>
                            <span x-text="weather.windSpeed"></span><span class="pl-1">м/с</span>
                        </div>
                        <div class="basis-1/4 sm:basis-1/2">
                            <p>Давление</p>
                            <span x-text="weather.pressure"></span><span class="pl-1">мм рт. ст.</span>
                        </div>
                        <div class="basis-1/4 sm:basis-1/2">
                            <p>Влажность</p>
                            <span x-text="weather.humidity"></span><span>%</span>
                        </div>
                        <div class="basis-1/4 sm:basis-1/2">
                            <p>Ощущается как:</p>
                            <span x-text="weather.feels"></span><span>&#176;</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @section('scripts')
        <script>
            function weather() {
                return {
                    city: 'moscow',
                    weather: [],
                    error: '',

                    getWeather() {
                        this.error = ''
                        this.weather = {
                            description: '',
                            temp: '',
                            feels: '',
                            pressure: '',
                            humidity: '',
                            windSpeed: '',
                            name: '',
                            icon: ''
                        }

                        if (this.city === '') {
                            return;
                        }

                        fetch('/api/' + this.city)
                            .then((res) => res.json())
                            .then((res) => {
                                if (!res['name']) {
                                    this.error = 'Error happened when fetching the API'
                                } else {
                                    this.weather.description = res.weather[0].description
                                    this.weather.description = this.ucfirst(res.weather[0].description)
                                    this.weather.temp = Math.round(res.main.temp)
                                    this.weather.feels = Math.round(res.main.feels_like)
                                    this.weather.pressure = res.main.pressure
                                    this.weather.humidity = res.main.humidity
                                    this.weather.windSpeed = res.wind.speed
                                    this.weather.name = res.name
                                    this.weather.icon = `https://openweathermap.org/img/wn/${res.weather[0].icon}@4x.png`
                                }
                            })
                    },
                    ucfirst(stringToConvert) {
                        return stringToConvert.charAt(0).toUpperCase() + stringToConvert.slice(1)
                    }
                }
            }
        </script>
    @endsection
</x-app-layout>
