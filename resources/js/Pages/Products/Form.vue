<template>
  <Layout>
    <div class="col-12 ">
      <div class="card shadow-lg">
        <!-- Main container header -->
        <div class="card-header">
          <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <el-button
                type="warning"
                plain
                @click="back()"
              >
                Назад
              </el-button>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="col-4">
            <el-form
              :model="form"
              label-position="left"
              @submit.prevent="submit"
            >
              <el-form-item
                required
                v-if="$page.props.user.is_admin"
                prop="article"
                label="Article"
                class="form-group"
              >
                <el-input
                  v-model="form.article"
                  placeholder="Article"
                  :disabled="!$page.props.user.is_admin"
                  type="text"
                ></el-input>
              </el-form-item>
              <el-form-item
                required
                prop="name"
                label="Name"
                class="form-group"
              >
                <el-input
                  v-model="form.name"
                  placeholder="Name"
                  type="text"
                ></el-input>
              </el-form-item>
              <el-form-item
                required
                prop="status"
                label="Status"
                class="form-group"
              >
                <el-select
                  v-model="form.status"
                  placeholder="Выберите статус"
                  :clearable="true"
                  class="w-100"
                >
                  <el-option
                    v-for="item in statuses"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id"
                  >
                  </el-option>
                </el-select>
              </el-form-item>

              <el-form-item label="Color name">
                <el-input v-model="form.options.color_name" />
              </el-form-item>
              <el-form-item label="Color value">
                <el-color-picker v-model="form.options.color_value" />
              </el-form-item>
<!--              <div
                v-for="(item, index) in form.options"
              >
                <el-form-item :label="index">
                  <el-input v-model="form.options[index]" />
                </el-form-item>
              </div>-->
<!--              <el-form-item
                v-for="(item, index) in form.data"
                :key="item.color_value"
                :label="item.color_name"
                :prop="item"
                :rules="{
                  required: true,
                  message: 'domain can not be null',
                  trigger: 'blur',
                }"
                class="form-group"
              >
                <div class="d-flex align-items-center">
                  <el-input v-model="item.color_name" />
                  <el-input v-model="item.color_value" />
                </div>
              </el-form-item>-->
              <el-form-item>
                <el-button
                  native-type="submit"
                  type="primary"
                >
                  Submit
                </el-button>
              </el-form-item>
            </el-form>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>

<script setup lang="ts">
import  Layout from "./../Layout/Layout.vue";

import { reactive, ref } from 'vue';

import { router, useForm } from '@inertiajs/vue3'

import { ElMessage } from 'element-plus'

interface FormDataItem {
  color_name: string
  color_value: string
}
interface FormData {
  id: number;
  article: string;
  name: string;
  status: string;
  options: FormDataItem
}

const props = defineProps({
  product: {
    type: Object as () => FormData,
    required: true,
  },
})
const statuses = ref([
  { id: 'available', name: 'Доступен' },
  { id: 'unavailable', name: 'Не доступен' },
])

let tmpForm = reactive<FormData>(props.product)
let form = useForm(tmpForm)

const back = () => {
  router.visit('/products')
}

const submit = (e) => {
  e.preventDefault()
  if (form.id) {
    form.put(`/products/${form.id}`, {
      onSuccess: () => ElMessage({
        message: 'Success',
        type: 'success',
      }),
      onError: (e) => Object.values(e).forEach((value) => ElMessage.error(value)),
    })
    // router.put(`/products/${form.id}`, form);
  } else {
    form.post('/products', {
      onSuccess: () => ElMessage({
        message: 'Success',
        type: 'success',
      }),
      onError: (e) => Object.values(e).forEach((value) => ElMessage.error(value)),
    })
    // router.post('/products', form);
  }
};
</script>

<style scoped lang="css">
.clickable {
  cursor: pointer;
}

.search--field {
  padding: 0 !important;
}

.page-link {
  color: #007bff !important;
}

.not-set {
  color: red;
}

.td-heading {
  width: 35%;
}

.td-text {
  width: 65%;
}
.el-date-editor.el-input, .el-date-editor.el-input__inner {
  max-width: 260px !important;
}
.hidden {
  display: none;
}
</style>
