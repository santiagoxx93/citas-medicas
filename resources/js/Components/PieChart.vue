<script setup>
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
import { Pie } from 'vue-chartjs'

// Registramos los elementos necesarios para gráficos circulares
ChartJS.register(ArcElement, Tooltip, Legend)

defineProps({
  chartData: {
    type: Object,
    required: true
  },
  chartOptions: {
    type: Object,
    default: () => ({
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom', // Leyenda abajo para que se vea mejor
        }
      }
    })
  }
})
</script>

<template>
  <div style="height: 300px; width: 100%;">
    <Pie :data="chartData" :options="chartOptions" />
  </div>
</template>