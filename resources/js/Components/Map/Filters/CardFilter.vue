<template>
  <div class="pt-2 mx-3 mt-2">
    <div class="card">
      <div class="card-header fs-6 p-3 pb-2">
        <slot name="CardHeader"></slot>
      </div>
      <div class="card-body p-2">
        <slot name="CardBody"></slot>
      </div>
    </div>
  </div>
</template>
