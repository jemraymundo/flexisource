<!DOCTYPE html>
<html>
  <head>
    <title>Pastries {{$boldDeals}}</title>
  </head>
  <body>
    <div>
      <p>Below is our offer of various pretzels...</p>
      <div {{$boldDeals ? 'class=bold-deals' : ''}}>
        <ul>Pretzels...</ul>
      </div> 
    </div>
  </body>
</html>
