const timestampFormat = (timestamp) => moment(timestamp).format('DD/MM/YYYY HH:mm:ss')

export default {
  /* eslint-disable no-param-reassign */
  install: (app) => {
    app.config.globalProperties.$timestampFormat = timestampFormat
  },
}
