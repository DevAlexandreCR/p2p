<template>
  <!-- Modal -->
  <div class="modal fade" id="user-modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="label-user-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <img src="/images/user.jpg" class="card-img-top img-product-detail" alt="...">
        <div class="modal-body">
          <table class="table table-borderless">
            <thead>
            <tr>
              <th>Name:</th>
              <td id="userName"></td>
            </tr>
            <tr>
              <th>Email:</th>
              <td id="userEmail"></td>
            </tr>
            <tr>
              <th>Status:</th>
              <td id="userEnabled"></td>
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
  name: "UserModalComponent",

  data() {
    return {
      user: {
        name: '',
        email: '',
        enabled: true
      }
    }
  },

  mounted() {
    let myModalEl = document.getElementById('user-modal')

    myModalEl.addEventListener('show.bs.modal', function (event) {
      let button = event.relatedTarget
      this.user = JSON.parse(button.getAttribute('data-bs-user'))
      myModalEl.querySelector('.modal-body td[id="userName"]').textContent = this.user.name
      myModalEl.querySelector('.modal-body td[id="userEmail"]').textContent = this.user.email
      myModalEl.querySelector('.modal-body td[id="userEnabled"]').textContent = this.user.enabled
    })
  }
}
</script>