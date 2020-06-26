<template>
  <div>
    <input
      type="text"
      v-model="filters.data.value"
      :placeholder="titleinput"
      class="form-control form-control-sm"
    />
  </div>
</template>
<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState(["filters"])
  },
  props: {
    titleinput: String,
    required: true
  }
};
</script>