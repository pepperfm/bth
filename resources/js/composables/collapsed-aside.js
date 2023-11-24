import { ref } from 'vue'
export function useToggleCollapse() {
  const collapsed = ref(false);

  function toggleCollapse() {
    collapsed.value = !collapsed.value;
  }

  return {
    collapsed,
    toggleCollapse
  };
}
