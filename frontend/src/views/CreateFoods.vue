<template>
  <div class="create-foods">
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
              <li class="breadcrumb-item">
                <router-link class="text-dark" to="/create-foods"
                  >Add Foods</router-link
                >
              </li>
            </ol>
          </nav>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-md-6">
          <img
            src="../assets/images/create.png"
            class="img"
            width="540"
            alt="..."
          />
        </div>
        <div class="col-md-6">
          <h2>
            Create
            <strong> Foods</strong>
          </h2>
          <hr />
          <form class="mt-4" @submit.prevent="createFood">
            <div class="form-group">
              <label for="kode">Kode</label>
              <input
                type="text"
                class="form-control"
                v-model="form.kode"
                required
              />
            </div>
            <div class="form-group">
              <label for="nama">Nama</label>
              <input
                type="text"
                class="form-control"
                v-model="form.nama"
                required
              />
            </div>
            <div class="form-group">
              <label for="harga">Harga</label>
              <input
                type="number"
                class="form-control"
                v-model="form.harga"
                required
              />
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="kategori">Kategori</label>
              </div>
              <select
                class="custom-select"
                id="kategori"
                v-model="form.kategori"
                required
              >
                <option value="">Choose...</option>
                <option value="makanan">Makanan</option>
                <option value="minuman">Minuman</option>
                <option value="cemilan">Cemilan</option>
              </select>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroupFileAddon01"
                  >Gambar</span
                >
              </div>
              <div class="custom-file">
                <input
                  type="file"
                  class="custom-file-input"
                  id="gambar"
                  @change="handleFileUpload"
                />
                <label class="custom-file-label" for="gambar">{{
                  fileName
                }}</label>
              </div>
            </div>
            <button type="submit" class="btn btn-success float-right">
              <b-icon-bookmark-plus></b-icon-bookmark-plus> Add
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import NavbarView from "@/components/NavbarView.vue";

export default {
  name: "CreateFoods",
  components: {
    NavbarView,
  },
  data() {
    return {
      form: {
        kode: "",
        nama: "",
        harga: "",
        kategori: "",
        gambar: null,
      },
      fileName: "Choose file",
    };
  },
  methods: {
    handleFileUpload(event) {
      this.form.gambar = event.target.files[0];
      this.fileName = this.form.gambar ? this.form.gambar.name : "Choose file";
    },
    createFood() {
      const formData = new FormData();
      formData.append("kode", this.form.kode);
      formData.append("nama", this.form.nama);
      formData.append("harga", this.form.harga);
      formData.append("kategori", this.form.kategori);
      if (this.form.gambar) {
        formData.append("gambar", this.form.gambar);
      }

      axios
        .post("http://127.0.0.1:8000/api/products", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then(() => {
          this.$toast.success("Food successfully added.", {
            type: "success",
            position: "top-right",
            duration: 3000,
            dismissible: true,
          });
          this.$router.push("/foods");
        })
        .catch((error) => {
          console.error("Error:", error.response.data);
          this.$toast.error("Failed to add food.", {
            type: "error",
            position: "top-right",
            duration: 3000,
            dismissible: true,
          });
        });
    },
  },
};
</script>

<style></style>
