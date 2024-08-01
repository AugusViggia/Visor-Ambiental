<template>
  <div class="head d-flex justify-content-between align-items-center">
    <strong>Ecorregión:</strong> {{ value.ecoregion.name }}
  </div>
  <div class="ps-2 pe-2 d-flex justify-content-between align-items-center">
    <div :style="`color:${value.iconStyle.backgroundColor}`">
      <i :class="`fa fa-${value.iconStyle.faStyle}`"></i>
      {{ value.subcategory.name }}
    </div>
    <a v-if="value.readonly" href="#" class="link-danger" title="Denunciar" @click.prevent="removePopup(value)">
      <i class="fas fa-exclamation-triangle fa-fw"></i>
      Denunciar
    </a>
  </div>

  <h6>{{ value.title }}</h6>
  <div class="content">
    <div class="description-container">
      <p class="text-justify lh-1 fw-normal">
        <strong>Descripción:</strong> {{ value.description }}
      </p>
    </div>
    <p class="mb-0 fs-6">
      <strong class="text-wrap">Fuente:</strong> {{ value.source }}
    </p>
    <p class="mb-0 fs-6">
      <strong class="text-wrap">Web:</strong>&nbsp;
      <a :href="value.url" style="{ color:blue;}" :title="`Ir a la fuente: ${value.url}`" class="text-decoration-underline" target="_blank">
         {{ value.url }}
        <i class="fas fa-arrow-up-right-from-square fa-fw"></i>
      </a>
    </p>

    <p class="mb-1 fs-6">
      <strong class="text-wrap">Altura:</strong> {{ value.altitude}} <small title="Metros sobre el nivel del mar">m.s.n.m.</small>
    </p>
  </div>
</template>
