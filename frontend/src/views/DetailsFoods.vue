<template>
  <div class="food-details">
    <NavbarView />
    <div class="container">
      <!-- Breadcrumb -->
      <div class="row mt-4">
        <div class="col">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <router-link class="text-dark" to="/">Home</router-link>
              </li>
              <li class="breadcrumb-item">
                <router-link class="text-dark" to="/foods">Foods</router-link>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                Detail Food
              </li>
            </ol>
          </nav>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-md-6">
          <img :src="product.gambar" class="img-fluid shadow" alt="..." />
        </div>
        <div class="col-md-6">
          <h2>
            <strong>{{ product.nama }}</strong>
          </h2>
          <hr />
          <h4>
            Harga : <strong>Rp. {{ product.harga }}</strong>
          </h4>
          <h4>
            Kode : <strong>{{ product.kode }}</strong>
          </h4>
          <h4>
            Kategori : <strong>{{ product.kategori }}</strong>
          </h4>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import NavbarView from "@/components/NavbarView.vue";
import axios from "axios";

export default {
  name: "DetailsFoods",
  components: {
    NavbarView,
  },
  data() {
    return {
      product: {},
      pesan: {},
    };
  },
  methods: {
    setProduct(data) {
      this.product = data;
      this.pesan.product_id = data.id_product;
    },
  },
  mounted() {
    axios
      .get(
        "http://127.0.0.1:8000/api/products/" + this.$route.params.id_product
      )
      .then((response) => this.setProduct(response.data.data))
      .catch((error) => console.log("Gagal:", error));
  },
};
</script>

<style scoped>
/* Your styles */
</style>
