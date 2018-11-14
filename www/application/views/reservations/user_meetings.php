<script>var calendar = <?= $calendar; ?>;

//JSON- group by rooms
result = calendar.reduce(function (r, a) {
    r[a.room] = r[a.room] || [];
    r[a.room].push(a);
    return r;
}, Object.create(null));

//creating new array for each room
var sources = [];
Object.keys(result).forEach(function(key){
    object = {};
    object.color = key.color;
    object.textColor = '#fff';
    object.events = result[key];
    sources.push(object);
})
</script>
<div class="py-4 z-0">
    <div id="calendar" class="z-2" data-user="<?= $this->user_data['user']['id'] ?>">
    </div>
</div>
<script src="/js/calendar.js"></script>