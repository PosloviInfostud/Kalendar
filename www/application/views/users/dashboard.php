<script>var calendar = <?= $calendar; ?>;

//JSON- group by rooms
result = calendar.reduce(function (r, a) {
    r[a.room] = r[a.room] || [];
    r[a.room].push(a);
    return r;
}, Object.create(null));

//generate random color for each room
function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

//creating new array for each room
console.log(result);
var sources = [];
Object.keys(result).forEach(function(key){
    object = {};
    object.color = key.color;
    object.textColor = '#fff';
    object.events = result[key];
    sources.push(object);
    console.log(key, result[key])
})
for (let i=0; i< result.length; i++) {

}

 console.log(sources);       
</script>
<div class="flex text-sm text-black pb-3 px-2 sm:px-0 border-b">
    <span>Reservations</span>
    <div class="fill-current h-2 w-2 mx-1 -mt-px">
        <?= file_get_contents("public/icons/chevron-right.svg") ?>
    </div>
    <span class="text-primary font-normal">Dashboard</span>
</div>
<div class="py-4">
    <div id="calendar" data-user="<?= $this->user_data['user']['id'] ?>">
    </div>
</div>
<script src="/js/calendar.js"></script>