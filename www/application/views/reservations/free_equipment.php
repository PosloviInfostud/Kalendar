<div class="form-group">
            <p>When?</p>
            <p>from <input type="text" name="start_time" id="datetime_start" placeholder="start datetime" class="text-center">
                to <input type="text" name="end_time" id="datetime_end" placeholder="end datetime" class="text-center">
        </p>
        </div>
        <div class="form-group">
            <label for="title">Why do you need it?</label>
            <input type="text" class="form-control" name="title" id="reservation_name">
        </div>
        <div class="form-group">
            <label for="description">Describe it more specifically</label>
            <textarea class="form-control" name="description" id="reservation_description"></textarea>
        </div>
        <input type="submit" name="submit" id="reservation_submit" class="btn btn-block btn-success" value="Reserve!">

