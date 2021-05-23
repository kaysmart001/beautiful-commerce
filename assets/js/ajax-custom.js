var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
    var matches, substringRegex;
    matches = [];
    substrRegex = new RegExp(q, 'i');
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        matches.push(str);
      }
    });
    cb(matches);
  };
};


var products = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        limit:100,
        remote: {
        'cache': false,
        url: 'getproducts.php?q=%QUERY',
        wildcard: '%QUERY',
        filter: function (data) {
            return data;
        }
    }
    });

    products.initialize();


$('.the-basics .typeahead').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
},
{
  name: 'products',
  display: 'name',
  source: products.ttAdapter(),
  templates: {
    empty: [
      '<div class="empty-message">',
        'No Product Found !',
      '</div>'
    ].join('\n'),
    suggestion: function (data) {
        return '<a href="product.php?id='+data.id+'" class="man-section"><div class="image-section"><img src='+data.image+'></div><div class="description-section"><h4>'+data.name+'</h4><span>'+data.price+'</span></div></a>';
    }
  },
});