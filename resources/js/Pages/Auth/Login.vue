<template>
  <div class="login">
    <el-card class="text-center">
      <h2>Example App</h2>
      <el-form
        ref="loginForm"
        class="login-form"
        :model="form"
        @submit.prevent="auth()"
      >
        <el-form-item
          required
          prop="email"
          class="form-group"
        >
          <el-input
            v-model="form.email"
            placeholder="Email"
            type="email"
          ></el-input>
        </el-form-item>
        <el-form-item
          required
          prop="password"
          class="form-group"
        >
          <el-input
            v-model="form.password"
            placeholder="Password"
            type="password"
          ></el-input>
        </el-form-item>
        <el-form-item>
          <el-button
            class="login-button"
            native-type="submit"
            type="primary"
          >
            Войти
          </el-button>
        </el-form-item>
      </el-form>
    </el-card>
  </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue'
import { router } from '@inertiajs/vue3'

const form = reactive({
  email: 'test@example.com',
  password: 'password',
})

const auth = () => {
  router.post('/login', {
    email: form.email,
    password: form.password,
  })
}
</script>
<style lang="scss" scoped>
.login {
  height: 100vh;
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}

.login .el-input__prefix {
  height: calc(100% - 2px);
  border-radius: 3px;

  .el-input__icon {
    width: 30px;
  }
}

.login-button {
  width: 100%;
  margin-top: 20px;
}

h2 {
  letter-spacing: 1px;
  padding-top: 10px;
  padding-bottom: 20px;
}

.login-form {
  width: 290px;
}

.login .el-card {
  width: 340px;
  display: flex;
  justify-content: center;
}

.el-input__wrapper {
  padding: 1px 1px !important;
}

</style>
