<template>
  <div class="home">
    <NavbarView />
    <div class="container">
      <HeroView />
      <div class="row mt-4">
        <div class="col">
          <h2>Best <strong>Foods</strong></h2>
        </div>
        <div class="col">
          <router-link to="/foods" class="btn btn-success float-right"
            ><b-icon-eye></b-icon-eye> Lihat Semua</router-link
          >
        </div>
      </div>
      <div class="row mb-4">
        <div
          class="col-md-4 mt-4"
          v-for="product in products"
          :key="product.id_product"
        >
          <CardProduct :product="product" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import NavbarView from "@/components/NavbarView.vue";
import HeroView from "@/components/HeroView.vue";
import CardProduct from "@/components/CardProduct.vue"; // Perbaiki typo
import axios from "axios";

export default {
  name: "HomeView",
  components: {
    NavbarView,
    HeroView,
    CardProduct, // Gunakan nama komponen yang benar
  },
  data() {
    return {
      products: [],
    };
  },
  methods: {
    setProduct(data) {
      console.log(data);
      this.products = data;
    },
  },
  mounted() {
    axios
      .get("http://127.0.0.1:8000/api/best-product")
      .then((response) => this.setProduct(response.data.data))
      .catch((error) => console.log("Gagal :", error));
  },
};
</script>
