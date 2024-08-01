module.exports = {
  env: {
    browser: true,
    es2021: true,
  },
  extends: [
    'plugin:vue/vue3-essential',
    'standard',
  ],
  parserOptions: {
    ecmaVersion: 'latest',
    sourceType: 'module',
  },
  plugins: [
    'vue',
  ],
  globals: {
    _: 'readonly',
    app: 'readonly',
    axios: 'readonly',
    bootstrap: 'readonly',
    moment: 'readonly',
    require: 'readonly',
    route: 'readonly',
    Vue: 'readonly',
  },
  rules: {
    'comma-dangle': [
      'error', {
        arrays: 'always-multiline',
        objects: 'always-multiline',
        imports: 'always-multiline',
        exports: 'always-multiline',
        functions: 'never',
      },
    ],
    'vue/script-setup-uses-vars': 'error',
    'vue/multi-word-component-names': ['error', {
      ignores: [
        'Banner',
        'Button',
        'Checkbox',
        'Dropdown',
        'Import',
        'index',
        'Index',
        'Input',
        'Label',
        'Link',
        'List',
        'Login',
        'Modal',
        'Pagination',
        'Textarea',
        'Register',
        'Search',
        'Show',
        'Stats',
        'Switch',
        'Welcome',
      ],
    }],
  },
}
