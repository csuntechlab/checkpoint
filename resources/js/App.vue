<template>
  <v-app>
    <div>
      <Navigation></Navigation>
      <router-view></router-view>
    </div>
  </v-app>
</template>
<script>
import Navigation from "./components/Navigation.vue";
export default {
  name: "App",
  components: {
    Navigation
  }
};
</script>
