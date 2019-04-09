<template>
  <v-app>
    <navigation></navigation>
    <router-view></router-view>
    <v-alert></v-alert>
  </v-app>
</template>
<script>
import navigation from "./components/global/navigation.vue";
export default {
  name: "App",
  components: {
    navigation
  }
};
</script>
