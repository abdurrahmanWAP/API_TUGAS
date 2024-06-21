<template>
  <div>
    <NavbarView />
    <div class="container">
      <div class="row mt-4">
        <div class="col">
          <h2>Daftar <strong>Makanan</strong></h2>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col">
          <div class="input-group mb-3">
            <input
              type="text"
              class="form-control"
              placeholder="Cari Makanan Kesukaan Anda..."
              aria-label="Cari"
              aria-describedby="basic-addon1"
              v-model="search"
              @input="searchFood"
            />
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"
                ><b-icon-search></b-icon-search
              ></span>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col">
          <router-link to="/create-foods" class="btn btn-success float-right"
            ><b-icon-bookmark-plus></b-icon-bookmark-plus> Add
            Foods</router-link
          >
        </div>
      </div>

      <div class="row mb-4">
        <div
          class="col-md-3 mt-4"
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
import NavbarView from "@/components/NavbarView.vue";
import CardProduct from "@/components/CardProduct.vue";
import axios from "axios";

export default {
  name: "FoodList",
  components: {
    NavbarView,
    CardProduct,
  },
  data() {
    return {
      products: [],
      search: "",
    };
  },
  methods: {
    setProduct(data) {
      this.products = data;
    },
    searchFood() {
      const query = this.search.trim();
      const url = query
        ? `http://127.0.0.1:8000/api/product/cari?nama=${query}`
        : "http://127.0.0.1:8000/api/product";
      axios
        .get(url)
        .then((response) => this.setProduct(response.data.data))
        .catch((error) => console.log("Gagal :", error));
    },
  },
  mounted() {
    this.searchFood();
  },
};
</script>

<style></style>
