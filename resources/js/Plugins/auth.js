/**
 * auth.js
 *
 * Plugin for setup roles and permissions from spatie permissions package.
 */

export default {
  install: (app, { roles, permissions }) => {
    app.config.globalProperties.$gates.setRoles(roles)
    app.config.globalProperties.$gates.setPermissions(permissions)
  },
}
