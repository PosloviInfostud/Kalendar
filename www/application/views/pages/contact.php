<div id="message" style="display:none"></div>

<form id="contact-form" novalidate>
  <fieldset>
    <div class="form-group">
      <label for="exampleInputEmail1">Name</label>
      <input type="text" class="form-control" name="contact_name" id="contact_name" placeholder="Enter name">
      <div class="text-danger small" id="contact_name_err"></div>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Email address</label>
      <input type="email" class="form-control" name="contact_email" id="contact_email" aria-describedby="emailHelp" placeholder="Enter email">
      <div class="text-danger small" id="contact_email_err"></div>
    </div>
    <div class="form-group">
      <label for="message">Message</label>
      <textarea class="form-control" name="contact_message" id="contact_message" rows="3"></textarea>
      <div class="text-danger small" id="contact_message_err"></div>
    </div>
    <button type="submit" id="contact_button" class="btn btn-primary">Submit</button>
  </fieldset>
</form>

<script src="/js/contact.js"></script>