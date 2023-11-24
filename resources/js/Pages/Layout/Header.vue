<template>
  <el-header style="display: flex; height: 57px;">
    <nav class="main-header navbar d-flex align-items-center justify-content-between">
      <div
        @click="toggleCollapse()"
        @keydown="toggleCollapse()"
      >
        <em :class="['fas fa-bars',  { rotate: collapsed }, 'burger']"></em>
      </div>
      <el-dropdown @command="handleCommand">
        <span class="currentUser">{{ $page.props.user.name }}</span>
        <template #dropdown>
          <el-dropdown-menu>
            <el-dropdown-item command="exit">Выход</el-dropdown-item>
          </el-dropdown-menu>
        </template>
      </el-dropdown>
    </nav>
  </el-header>
</template>

<script setup lang="ts">
import { useToggleCollapse } from '../../composables/collapsed-aside.js'
import { router } from "@inertiajs/vue3";
const { collapsed, toggleCollapse } = useToggleCollapse()

const handleCommand = () => {
    router.get('/logout')
}
</script>

<style lang="css" scoped>
.main-header {
  width: 100%;
}
.rotate {
  transform: rotate(270deg);
}

.burger {
  transition: all 300ms ease-in-out;
  font-size: 20px !important;
  color: rgba(0, 0, 0, 0.5);
}

.burger:hover {
  color: rgba(0, 0, 0, 0.7);
}

.el-dropdown-link {
  width: 100%;
}

.logo {
  width: 220px;
  text-align: center;
}

.el-menu--horizontal > .el-menu-item.is-active {
  border: 0;
}

.el-menu-demo li {
  padding: 0 10px;
}
</style>
