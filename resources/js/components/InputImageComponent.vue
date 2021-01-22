<template>
  <div class="input-group mb-3">
    <input type="file" class="form-control" :id="name"
           accept="image/jpeg,image/jpg,image/png" :name="name" @change="imgPreview">
    <label class="input-group-text" :for="name">
      <i class="bi bi-image-fill"></i>
    </label>
  </div>
</template>

<script>
export default {
  name: "input-image-component",

  props: {
    name: {
      type: String,
      required: true
    },
    imgId: {
      type: String,
      default: null,
      required: false
    }
  },

  methods: {
    imgPreview(e) {
      const file = e.target.files[0]
      let img = document.getElementById(this.imgId)
      img.src = URL.createObjectURL(file);
    }
  }
}
</script>