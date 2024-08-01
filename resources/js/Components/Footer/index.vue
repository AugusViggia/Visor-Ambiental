<template>
  <footer class="py-3 footer">
    <div class="container-fluid">
      <div class="row align-items-center justify-content-lg-between">
        <div class="mb-4 col-lg-6 mb-lg-0">
          <div
            class="text-sm text-center copyright text-muted text-lg-start"
          >
            ©
            {{ new Date().getFullYear() }}, made with
            <i class="fa fa-heart"></i> by
            <a
              :href="$page.props.application.app_developers_site"
              class="font-weight-bold"
              target="_blank"
              >{{  $page.props.application.app_developers  }}</a
            >
            for a better World.
          </div>
        </div>
        <div class="col-lg-6">
          <ul
            class="nav nav-footer justify-content-center justify-content-lg-end"
          >
            <li class="nav-item">
              <span
                class="nav-link text-muted"
                >{{  $page.props.application.app_version  }}</span
              >
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'app-footer',
}
</script>
