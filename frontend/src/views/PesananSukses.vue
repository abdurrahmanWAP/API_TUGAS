<template>
  <div class="pesanan-sukses">
    <NavbarView />
    <div class="container">
      <div class="row justify-content-center mt-5">
        <div class="col text-center">
          <img src="../assets/images/menunggu.png" width="300" />
          <h2><strong>Sukses!!!</strong></h2>
          <h2>
            Pesanan Anda segera diprosess <br />
            Selamast Menunggu
          </h2>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import NavbarView from "@/components/NavbarView.vue";

export default {
  name: "PesananSukses",
  components: {
    NavbarView,
  },
};
</script>

<style></style>
