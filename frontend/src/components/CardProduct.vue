<template>
  <div class="card shadow card-product">
    <img :src="product.gambar" class="card-img-top" alt="..." />
    <div class="card-body">
      <h5 class="card-title">{{ product.nama }}</h5>
      <p class="card-text">Harga : Rp {{ product.harga }}</p>
      <router-link class="btn btn-success" :to="'/foods/' + product.id_product"
        ><b-icon-cart></b-icon-cart>Pesan</router-link
      >
      <router-link
        class="btn btn-danger float-right"
        :to="'/detail-food/' + product.id_product"
        ><b-icon-exclamation-circle></b-icon-exclamation-circle>
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: "CardProduct",
  props: ["product"],
};
</script>

<style></style>
