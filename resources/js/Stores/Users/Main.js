import { defineStore } from 'pinia'

export const useUsersStore = defineStore('usersStore', {
  state: () => {
    return {
      users: [],
    }
  },
  actions: {
    setUsers (users) {
      this.users = users
    },
    fetch (query, loading) {
      if (query.length < 3) {
        return
      }
      loading(true)
      return axios.get(route('api.users.index'), { params: { name: query } }).then((res) => {
        this.setUsers(res.data)
        loading(false)
      })
    },
  },
  getters: {
    get () {
      return this.users
    },
  },
})
