<template>
    <div>
        <navigation></navigation>
        <router-view></router-view>
    </div>
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
