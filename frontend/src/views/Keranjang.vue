<template>
  <div class="keranjang">
    <NavbarView :updateKeranjang="keranjangs" />
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
                Keranjang
              </li>
            </ol>
          </nav>
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
                  <th scope="col">Foto</th>
                  <th scope="col">Makanan</th>
                  <th scope="col">Keterangan</th>
                  <th scope="col">Jumlah</th>
                  <th scope="col">Harga</th>
                  <th scope="col">Total Harga</th>
                  <th scope="col">Hapus</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="(keranjang, index) in keranjangs"
                  :key="keranjang.id_keranjang"
                >
                  <th>{{ index + 1 }}</th>
                  <td>
                    <img
                      :src="`http://127.0.0.1:8000/storage/${keranjang.product.gambar}`"
                      class="img-fluid shadow"
                      width="250"
                      alt="..."
                    />
                  </td>
                  <td>{{ keranjang.product.nama }}</td>
                  <td>
                    {{ keranjang.keterangan ? keranjang.keterangan : "-" }}
                  </td>
                  <td>{{ keranjang.jumlah_pesanan }}</td>
                  <td>Rp. {{ keranjang.product.harga }}</td>
                  <td>
                    <strong
                      >Rp.
                      {{
                        (
                          keranjang.jumlah_pesanan * keranjang.product.harga
                        ).toFixed(2)
                      }}</strong
                    >
                  </td>
                  <td align="center" class="text-danger">
                    <button
                      @click="hapusKeranjang(keranjang.id_keranjang)"
                      class="btn btn-danger"
                    >
                      <b-icon-trash></b-icon-trash>
                    </button>
                  </td>
                </tr>

                <tr>
                  <td colspan="6" align="right">
                    <strong>Total Harga : </strong>
                  </td>
                  <td align="right">
                    <strong>Rp. {{ totalHarga.toFixed(2) }}</strong>
                  </td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Form Checkout -->
      <div class="row justify-content-end">
        <div class="col-md-4">
          <form class="mt-4" v-on:submit.prevent="checkout">
            <div class="form-group">
              <label for="nama">Nama :</label>
              <input type="text" class="form-control" v-model="pesan.nama" />
            </div>
            <div class="form-group">
              <label for="nomor_kerja">Nomor Meja :</label>
              <input
                type="text"
                class="form-control"
                v-model="pesan.nomor_kerja"
              />
            </div>
            <button type="submit" class="btn btn-success float-right">
              <b-icon-cart></b-icon-cart> Pesan
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
  name: "KeranjangView",
  components: {
    NavbarView,
  },
  data() {
    return {
      keranjangs: [],
      pesan: {
        nama: "",
        nomor_kerja: "",
        total_harga: 0,
      },
    };
  },
  methods: {
    setKeranjangs(data) {
      this.keranjangs = data;
    },
    hapusKeranjang(id) {
      axios
        .delete(`http://127.0.0.1:8000/api/keranjangs/${id}`)
        .then(() => {
          this.keranjangs = this.keranjangs.filter(
            (k) => k.id_keranjang !== id
          );
          this.$toast.success("Item berhasil dihapus dari keranjang.", {
            type: "success",
            position: "top-right",
            duration: 3000,
            dismissible: true,
          });
        })
        .catch((error) => {
          if (error.response && error.response.data) {
            console.log("Gagal:", error.response.data);
            this.$toast.error("Gagal menghapus item dari keranjang.", {
              type: "error",
              position: "top-right",
              duration: 3000,
              dismissible: true,
            });
          } else {
            console.log("Gagal:", error.message);
            this.$toast.error("Terjadi kesalahan.", {
              type: "error",
              position: "top-right",
              duration: 3000,
              dismissible: true,
            });
          }
        });
    },
    checkout() {
      if (this.pesan.nama && this.pesan.nomor_kerja) {
        const requests = this.keranjangs.map((keranjang) => {
          return {
            nama: this.pesan.nama,
            nomor_kerja: this.pesan.nomor_kerja,
            keranjang_id: keranjang.id_keranjang,
            total_harga: this.totalHarga,
          };
        });

        console.log("Payload:", { pesanan: requests }); // Tambahkan log ini untuk verifikasi

        axios
          .post("http://127.0.0.1:8000/api/pesanans", {
            pesanan: requests,
          })
          .then(() => {
            // Hapus Semua Keranjang
            const deleteRequests = this.keranjangs.map((keranjang) => {
              return axios.delete(
                `http://127.0.0.1:8000/api/keranjangs/${keranjang.id_keranjang}`
              );
            });

            // Jalankan penghapusan dan tunggu semua request selesai
            Promise.all(deleteRequests)
              .then(() => {
                this.$router.push({ path: "/pesanan-sukses" });
                this.$toast.success("Pesanan berhasil dibuat.", {
                  type: "success",
                  position: "top-right",
                  duration: 3000,
                  dismissible: true,
                });
                this.keranjangs = [];
                this.pesan.nama = "";
                this.pesan.nomor_kerja = "";
              })
              .catch((error) => {
                console.log("Gagal menghapus keranjang:", error);
              });
          })
          .catch((error) => {
            console.log("Gagal membuat pesanan:", error);
            this.$toast.error("Gagal membuat pesanan.", {
              type: "error",
              position: "top-right",
              duration: 3000,
              dismissible: true,
            });
          });
      } else {
        this.$toast.error("Nama dan Nomor Meja Harus diisi.", {
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
      .get("http://127.0.0.1:8000/api/keranjangs")
      .then((response) => this.setKeranjangs(response.data))
      .catch((error) => console.log("Gagal:", error));
  },
  computed: {
    totalHarga() {
      return this.keranjangs.reduce((total, keranjang) => {
        return (
          total + parseFloat(keranjang.product.harga) * keranjang.jumlah_pesanan
        );
      }, 0);
    },
  },
};
</script>

<style></style>
