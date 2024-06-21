<template>
    <div id="app">
        <router-view />
        <FooterView />
    </div>
</template>

<script>
import FooterView from "@/components/FooterView.vue";

export default {
    components: {
        FooterView,
    },
};
</script>
