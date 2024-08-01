<template>
  <div class="container">
    <div class="row">
      <div class="mx-auto col-xl-4 col-lg-5 col-md-6 d-flex flex-column">
        <div class="mt-8 card card-plain">
          <div class="pb-0 card-header text-start bg-transparent">
            <slot name="cardHeader" />
          </div>
          <div class="card-body">
            <slot />
          </div>
          <div class="px-1 pt-0 text-center card-footer px-lg-2">
            <p class="mx-auto mb-4 text-sm">
              ¿No tienes una cuenta?
              <a
                :href="route('register')"
                class="text-success text-gradient font-weight-bold"
                title="Solicitar cuenta"
              >
                Solicita una aquí.
              </a>
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div
          class="top-0 oblique position-absolute h-100 d-md-block d-none me-n8"
        >
          <div
            class="bg-cover oblique-image position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
            :class="'bg-option-1'"
          ></div>
        </div>
      </div>
    </div>
  </div>
</template>
