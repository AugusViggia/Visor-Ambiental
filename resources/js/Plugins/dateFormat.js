import moment from 'moment'

export default {
  install: (app) => {
    app.config.globalProperties.$dateFormat =
      (value, invert) => {
        let format = 'DD/MM/YYYY'

        if (invert) {
          format = 'YYYY-MM-DD'
        }

        return moment(String(value)).format(format)
      }
  },
}
