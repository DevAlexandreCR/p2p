<template>
  <!-- Modal -->
  <div class="modal fade" id="product-modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="label-product-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <img :src="imagePath + 'default.png'" class="card-img-top img-product-detail" alt="...">
        <div class="modal-body">
          <table class="table table-borderless">
            <thead>
            <tr>
              <th>Name:</th>
              <td id="productName"></td>
            </tr>
            <tr>
              <th>Reference:</th>
              <td id="productReference"></td>
            </tr>
            <tr>
              <th>Description:</th>
              <td id="productDescription"></td>
            </tr>
            <tr>
              <th>Stock:</th>
              <td id="productStock"></td>
            </tr>
            <tr>
              <th>Price:</th>
              <td id="productPrice"></td>
            </tr>
            </thead>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ProductModalComponent',

  data () {
    return {
      product: {
        name: '',
        reference: '',
        description: '',
        stock: 0,
        price: 0
      }
    }
  },

  mounted () {
    const myModalEl = document.getElementById('product-modal')

    myModalEl.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget
      this.product = JSON.parse(button.getAttribute('data-bs-product'))
      myModalEl.querySelector('.modal-body td[id="productName"]').textContent = this.product.name
      myModalEl.querySelector('.modal-body td[id="productReference"]').textContent = this.product.reference
      myModalEl.querySelector('.modal-body td[id="productDescription"]').textContent = this.product.description
      myModalEl.querySelector('.modal-body td[id="productStock"]').textContent = this.product.stock
      myModalEl.querySelector('.modal-body td[id="productPrice"]').textContent = this.product.price
      myModalEl.querySelector('.modal-content img').src = imagePath + this.product.image
    })
  }
}
</script>
