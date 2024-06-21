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
                Food Order
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
          <form class="mt-4" v-on:submit.prevent>
            <div class="form-group">
              <label for="jumlah_pesanan">Jumlah Pesanan</label>
              <input
                type="number"
                class="form-control"
                v-model="pesan.jumlah_pesanan"
              />
            </div>
            <div class="form-group">
              <label for="keterangan">Keterangan</label>
              <textarea
                v-model="pesan.keterangan"
                class="form-control"
                placeholder="Keterangan spt : Pedes, Nasi Setengah..."
              ></textarea>
            </div>
            <button type="submit" class="btn btn-success" @click="pemesanan">
              <b-icon-cart></b-icon-cart> Pesan
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import NavbarView from "@/components/NavbarView.vue";
import axios from "axios";

export default {
  name: "FoodDetails",
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
    pemesanan() {
      if (this.pesan.jumlah_pesanan) {
        axios
          .post("http://127.0.0.1:8000/api/keranjangs", this.pesan)
          .then(() => {
            this.$router.push({ path: "/keranjang" });
            this.$toast.success("Sukses Masuk Keranjang.", {
              type: "success",
              position: "top-right",
              duration: 3000,
              dismissible: true,
            });
          })
          .catch((error) => {
            if (error.response && error.response.data) {
              console.log("Gagal:", error.response.data);
            } else {
              console.log("Gagal:", error.message);
            }
          });
      } else {
        this.$toast.error("Jumlah pesanan harus diisi.", {
          type: "error",
          position: "top-right",
          duration: 3000,
          dismissible: true,
        });
      }
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
