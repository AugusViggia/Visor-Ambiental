<template>
  <div class="d-flex justify-content-end align-items-end">
    <tr>
      <td>
        <span class="small font-italic align-text-bottom p-1"
          >Total Puntos : {{ total }}
        </span>
      </td>
      <td v-for="stat in stats" :key="stat.id">
        <span class="small font-italic align-text-bottom p-1"
          >{{stat.name}}{{'s: '}} {{stat.count}} </span
        >
      </td>
    </tr>
  </div>
</template>

<script setup>
import { onMounted, ref, getCurrentInstance } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'

const stats = ref([])
const total = ref(0)
const { user } = usePage().props.value
const gates = getCurrentInstance().appContext.app.config.globalProperties.$gates
const emit = defineEmits(['failed'])

async function getPointsStats () {
  try {
    if (gates.hasRole('ADM')) {
      await axios.get(route('api.points.stats.admin')).then((response) => {
        stats.value = response.data.stats
        total.value = response.data.total
      })
    } else {
      await axios
        .get(
          route('api.points.stats.user', {
            id: user.id,
          })
        )
        .then((response) => {
          stats.value = response.data.stats
          total.value = response.data.total
        })
    }
  } catch (error) {
    emit('failed', error)
  }
}

onMounted(() => {
  getPointsStats()
})
</script>
