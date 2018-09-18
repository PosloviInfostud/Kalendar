<div id="message"></div>

<form id="contact-form">
  <fieldset>
    <div class="form-group">
      <label for="exampleInputEmail1">Name</label>
      <input type="text" class="form-control" name="contact-name" id="contact-name" placeholder="Enter name">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Email address</label>
      <input type="email" class="form-control" name="contact-email" id="contact-email" aria-describedby="emailHelp" placeholder="Enter email">
      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
      <label for="message">Message</label>
      <textarea class="form-control" name="contact-message" id="contact-message" rows="3"></textarea>
    </div>
    <button type="submit" id="contact-button" class="btn btn-primary">Submit</button>
  </fieldset>
</form>

<script src="/js/contact.js"></script>