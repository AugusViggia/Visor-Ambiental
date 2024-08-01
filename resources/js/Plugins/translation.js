export default {
  install: (app, options) => {
    app.config.globalProperties.$__ = (key, replace) => {
      let translation = options[key] || key

      if (replace) {
        Object.keys(replace).forEach(function (attr) {
          translation = translation.replace(':' + attr, replace[attr])
        })
      }

      return translation
    }
  },
}
