<template>
  <el-container>
    <Aside />
    <el-container class="flex-column">
      <Header />
      <el-main style="height:100%">
        <slot />
      </el-main>
    </el-container>
  </el-container>
</template>

<script setup>
import Aside from "./Aside.vue";
import Header from "./Header.vue";
</script>
