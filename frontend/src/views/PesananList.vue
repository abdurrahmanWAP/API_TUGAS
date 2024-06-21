<template>
  <div>
    <NavbarView />
    <div class="container">
      <div class="row mt-4">
        <div class="col">
          <h2>Daftar <strong>Makanan</strong></h2>
        </div>
      </div>

      <div class="row">
        <div class="col">
          <h2>Keranjang <strong>Saya</strong></h2>
          <div class="table-responsive mt-3">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nama</th>
                  <th scope="col">Nomor Meja</th>
                  <th scope="col">Total Harga</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(pesanan, index) in uniquePesanans" :key="index">
                  <th>{{ index + 1 }}</th>
                  <td>{{ pesanan.nama }}</td>
                  <td>{{ pesanan.nomor_kerja }}</td>
                  <td>Rp. {{ pesanan.total_harga }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import NavbarView from "@/components/NavbarView.vue";
import axios from "axios";

export default {
  name: "PesananList",
  components: {
    NavbarView,
  },
  data() {
    return {
      pesanans: [],
    };
  },
  computed: {
    uniquePesanans() {
      const uniquePesanans = [];
      const seen = new Set();
      this.pesanans.forEach((pesanan) => {
        const key = pesanan.nama + "-" + pesanan.nomor_kerja;
        if (!seen.has(key)) {
          seen.add(key);
          uniquePesanans.push(pesanan);
        }
      });
      return uniquePesanans;
    },
  },
  methods: {
    setPesanans(data) {
      this.pesanans = data;
    },
  },
  mounted() {
    axios
      .get("http://127.0.0.1:8000/api/pesanans")
      .then((response) => this.setPesanans(response.data.data))
      .catch((error) => console.log("Gagal:", error));
  },
};
</script>

<style></style>
