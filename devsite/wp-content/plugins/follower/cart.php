<div id="cart">
  {% if cart.item_count == 0 %}
  <div class="row">
    <div class="span12 expanded-message">
      <h2>Your cart is empty</h2>
    </div> <!-- /.span12 -->
  </div> <!-- /.row -->

  {% unless settings.featured_products == blank or collections[settings.featured_products].empty? or collections[settings.featured_products].products_count == 0 %}
  {% assign collection = collections[settings.featured_products] %}
  <div class="row products masonry featured-collections">
    {% for product in collection.products limit: 3 %}
    {% include 'product-loop' with settings.featured_products %}
    {% endfor %}
  </div>
  {% endunless %}

  {% else %}
  <div class="row">
    <div class="span12">
      <h1>&nbsp;</h1>
      <table id="carttable">
        <thead>
          <tr>
            <th class="image">&nbsp;</th>
            <th class="item">Item</th>
            <th class="qty">Quantity</th>
            <th class="price">Price</th>
            <th class="remove">Remove</th>
          </tr>
        </thead>
        <tbody>
          {% for item in cart.items %}
          {% if item.product.tags contains "Advance-Product" %}
          <tr class="{% include 'mw_PO_cart', code: 'class' %}" {% include 'mw_PO_cart' with item, code: 'style' %}>
           <td class="image">
             {% include 'mw_PO_cart' with item, code: 'relation' %}
              <div class="product_image">
                <a href="{{ item.url }}">
                  <img src="{{ item | img_url: 'compact' }}"  alt="{{ item.title | escape }}" />
                </a>
              </div>
            </td>
            <td class="item cart-title" style=" font-size:14px; color:#000;">
              <a href="{{ item.url }}">{{ item.title }}</a><br>
              {% include 'mw_PO_cart' with item, code: 'properties' %}
            </td>
            <td class="qty">
              <input type="text"  size="4" name="updates[]" id="updates_{{ item.id }}" value="{{ item.quantity }}" onfocus="this.select();" class="tc item-quantity" />
            </td>
            <td class="price"><span style="display:none;">{% include 'mw_PO_cart' with item, code: 'price' %}</span>{% include 'mw_PO_cart' with item, code: 'line_price' %}</td>
            <td class="remove"><a class="removeqty" href="/cart/change?line={{ forloop.index }}&quantity=0" class="cart">Remove</a></td>
          </tr>            

          {% if item.product.tags contains "Advance-Product" %}
          {% for p in item.properties %}
          {% if p.first == 'CustomUniqueNumber'%}          
          {% for itemExtra in cart.items %}         
          {% if itemExtra.product.tags contains "Advance-Product" %}
          {% else %}
          {% for pExtra in itemExtra.properties %}
          {% if pExtra.first == 'CustomUniqueNumber'%}
          {% if pExtra.last == p.last %}
          <tr class="extras">
            <td>
              <!-- No image -->
            </td>
            <td>
              <div>
                <span style="text-transform:uppercase; font-family:roboto, lato, arial; font-weight:100;">{{ itemExtra.product.title }}</span>
                {% if itemExtra.product.variants.size > 1 %}
                <span style="text-transform:uppercase; font-family:roboto, lato, arial; font-weight:100;"> - {{ itemExtra.variant.title }}</span>
                {% endif %}
                <br>
              </div>
              <div>                  
                <!--<p class="">{{ itemExtra.price | money }} x {{ itemExtra.quantity }}</p>-->

              </div>
              <div>
                {% capture imgsrc %}{{ itemExtra | img_url: 'small' }}{% endcapture %}
                {% if imgsrc contains 'no-image'%}
                {% else %}
                <img style="border:1px solid #000; margin-top:10px;" src="{{ imgsrc }}"  alt="{{ itemExtra.title | escape }}" />
                {% endif %}
              </div>
              <br>
              <br>
              <br>
            </td>
            <td class="qty">
              <input size="4"  onfocus="this.select();" class="tc item-quantity replace text-center qtyExtra" data-u="{{pExtra.last}}" type="text" id="updates_{{ itemExtra.id }}" name="updates[]" value="{{ itemExtra.quantity }}" />
            </td>
            <td class="price">{{ itemExtra.line_price | money |  remove: ' '}}</td>
            <td class="remove"><a class="removeqty" href="" class="cart">Remove</a></td>    
          </tr>
          {% endif %}
          {% endif %}
          {% endfor %}
          {% endif %}
          {% endfor %}
          {% endif %}
          {% endfor %}
          {% endif %}


          {% endif %}
          {% endfor %}
        </tbody>
        <tfoot>
          <tr class="summary">
            <td class="image">&nbsp;</td>
            <td>&nbsp;</td>
            <td class="price tc" colspan="3"><span class="total" style="font-weight:bold;"><h2>TOTAL {{ cart.total_price | money |  remove: ' ' }}</h2></span></td>
          </tr>
        </tfoot>
      </table>
    </div> <!-- /.span12 -->
  </div> <!-- /.row -->
  <div class="row">
    <form action="/cart" method="post" id="cartform">
      <div id="cartinputelements">
        {% for item in cart.items %}
        <input type="hidden" name="updates[]" data-id="updates_{{ forloop.index }}" value="{{ item.quantity }}"/>
        {% endfor %}
      </div>
      <div class="buttons clearfix">        
        <input type="submit" id="checkout" class="btn" name="checkout" value="Checkout" />
        <input type="submit" id="update-cart" class="btn" name="update" value="Update" />
        <a href="/collections/sofas" class="btn" id="conitnueshiping" style="">Continue Shopping</a>
      </div>
    </form>
    {%comment%}<p style="text-transform:uppercase; font-size:10px; text-align:right; margin-top:15px;">all furniture is final sale</p>{%endcomment%}

    <div class="extra-checkout-buttons span6">
      {% if additional_checkout_buttons %}
      {{ content_for_additional_checkout_buttons }}
      {% endif %}
    </div>
    {% if settings.display_cart_note %}
    <div class="span6">
      <div class="checkout-buttons clearfix" id="notelabel">
        <label for="note" >Add special instructions for your order...</label>
        <textarea id="note" name="note" rows="10" cols="50">{{ cart.note }}</textarea>
      </div>
    </div>
    {% endif %}
  </div> <!-- /.row -->
  {% endif %}

</div> <!-- /#cart -->
<script>
  var cartobject = {{cart | json}};
  
  $(document).ready(function(){

    var othercartitem = [];
    var customCartitem = [];
    var mainCartitem = [];
    $.each(cartobject.items,function(i,item){
      item.itemindex = i+1;
      if(typeof item.properties !== "undefined"){
        if( item.properties && typeof item.properties.CustomUniqueNumber !== "undefined" && item.properties.CustomUniqueNumber){
          if( item.properties && typeof item.properties.MainProduct  !== "undefined" && item.properties.MainProduct ){          
            mainCartitem.push(item);
          }
          else{
            customCartitem.push(item);
          }
        }
        else{
          othercartitem.push(item);
        }
      }
      else{
        othercartitem.push(item);
      }
    }); 


    $('#carttable tbody').html('');
    $.each(mainCartitem,function(i,item){
      var tr = $('<tr class="mainproduct" data-u="'+item.properties.CustomUniqueNumber+'">')
      var td = $('<td class="image">');    
      var div = $('<div class="product_image">');
      var a = $('<a href="'+item.url+'">');
      var img = $('<img>');
      img.attr('src',item.image);    
      a.append(img);
      div.append(a);
      td.append(div);
      tr.append(td);

      td = $('<td class="item cart-title" style=" font-size:14px;">');
      a = $('<a>');
      a.attr('href',item.url);    
      var s = $('<strong>');
      s.html(item.product_title);
      a.append(s);
      
      
      
      td.append(a);      
      td.append('<br>');
      $.each(item.variant_options,function(i,option ){
      	td.append('<div><small style="color: #999;">'+option+'</small></div>');  
      });
             
      
      tr.append(td);

      td = $('<td class="qty">');    
      var input = '<input type="text"  size="4" name="updates[]" id="updates_'+item.itemindex+'" value="'+item.quantity+'" onfocus="this.select();" class="tc item-quantity" />';
      td.append(input);
      tr.append(td);

      td = $('<td class="price">');
      td.html('$'+(item.line_price/100).toFixed(2));
      tr.append(td);

      var td = $('<td class="remove">');
      td.append('<a class="removeqty" href="/cart/change?line=' + item.itemindex +'&amp;quantity=0" class="cart">Remove</a></td>');
      tr.append(td);

      $('#carttable tbody').append(tr);
      $.each(customCartitem,function(i,itemExtra){
        if(itemExtra.used != 1 && itemExtra.properties.CustomUniqueNumber == item.properties.CustomUniqueNumber){
          itemExtra.used = 1;
          var tr = $('<tr class="extras" data-e="'+item.properties.CustomUniqueNumber+'">')
          var td = $('<td class="image">');   
          tr.append(td);

          var tbb = '<td class="item cart-title" style="font-size:14px;padding-top: 0px;">'        
          +'<div style="display:table;width:100%">'
          +'<div class="extra-image" style="">';
          if( itemExtra.image ){
            tbb += '<img style="" src="'+itemExtra.image+'">';
          }
          else{
            tbb += '&nbsp;';
          }
  		  
          tbb += '</div>'
          
          if( itemExtra.vendor == "Clad Home Custom Product"){            
            tbb += '<div class="extratitle" style="">'
            +itemExtra.variant_title
            +'<br>';
            tbb += '</div>';
          }
          else{            
            tbb += '<div class="extra-title">'
            +itemExtra.product_title.replace('-', " ").replace('-', " ")
            +'<br>';
            tbb += '</div>';
          }
          
          
          
          +'</div></td>';

          tr.append(tbb);

          td = $('<td class="qty">');    
          var input = '<input type="text"  size="4" readonly name="updates[]" id="updates_'+itemExtra.itemindex+'" value="'+itemExtra.quantity+'" onfocus="this.select();" class="tc item-quantity qtyExtra" />';
          td.append(input);
          tr.append(td);

          td = $('<td class="price">');
          td.html('$'+(itemExtra.line_price/100).toFixed(2));
          tr.append(td);

          var td = $('<td >');
          td.append('</td>');
          tr.append(td);

          $('#carttable tbody').append(tr);
        }
      });

    });

    $.each(customCartitem,function(i,itemExtra){
      if(itemExtra.used != 1 ){
        itemExtra.used = 1;
        var tr = $('<tr>')
        var td = $('<td class="image">');    
        var div = $('<div class="product_image">');
        var a = $('<a href="'+itemExtra.url+'">');
        var img = $('<img style="max-width:120px">');
        img.attr('src',itemExtra.image);    
        a.append(img);
        div.append(a);
        td.append(div);
        tr.append(td);

        td = $('<td class="item cart-title" style=" font-size:14px;">');
        a = $('<a>');
        a.attr('href',itemExtra.url);    
        var s = $('<strong>');
        s.html(itemExtra.title);
        a.append(s);
        td.append(a);
        td.append('<br>');
        tr.append(td);

        td = $('<td class="qty">');    
        var input = '<input type="text"  size="4" name="updates[]" id="updates_'+itemExtra.itemindex+'" value="'+itemExtra.quantity+'" onfocus="this.select();" class="tc item-quantity" />';
        td.append(input);
        tr.append(td);

        td = $('<td class="price">');
        td.html('$'+(itemExtra.line_price/100).toFixed(2));
        tr.append(td);

        var td = $('<td class="remove">');
        td.append('<a class="removeqty" href="/cart/change?line=' + itemExtra.itemindex +'&amp;quantity=0" class="cart">Remove</a></td>');
        tr.append(td);

        $('#carttable tbody').append(tr);
      }
    });

    $.each(othercartitem,function(i,item){
      var tr = $('<tr>')
      var td = $('<td class="image">');    
      var div = $('<div class="product_image">');
      var a = $('<a href="'+item.url+'">');
      var img = $('<img style="max-width:120px">');
      img.attr('src',item.image);    
      a.append(img);
      div.append(a);
      td.append(div);
      tr.append(td);

      td = $('<td class="item cart-title" style=" font-size:14px;">');
      a = $('<a>');
      a.attr('href',item.url);    
      var s = $('<strong>');
      s.html(item.title);
      a.append(s);
      td.append(a);
      td.append('<br>');
      tr.append(td);

      td = $('<td class="qty">');    
      var input = '<input type="text"  size="4" name="updates[]" id="updates_'+item.itemindex+'" value="'+item.quantity+'" onfocus="this.select();" class="tc item-quantity" />';
      td.append(input);
      tr.append(td);

      td = $('<td class="price">');
      td.html('$'+(item.line_price/100).toFixed(2));
      tr.append(td);

      var td = $('<td class="remove">');
      td.append('<a class="removeqty" href="/cart/change?line=' + item.itemindex +'&amp;quantity=0" class="cart">Remove</a></td>');
      tr.append(td);

      $('#carttable tbody').append(tr);

    });

    $('#update-cart, #checkout').click(function(e){
      //e.preventDefault();
      $('.item-quantity').each(function(){
        var $tr = $(this).closest('tr');
        var u = $tr.attr('data-u');
        var qtyval = $(this).val();
        var id = $(this).attr('id');
        console.log('test');
        var it = $('<input[data-id="'+id+'"]');
        console.log(it);
        it.val(qtyval);
        $(this).val(qtyval);        
        if($tr.hasClass('mainproduct')){
          var nexttr = $('tr[data-e="'+u+'"]');
          nexttr.each(function(){
            if($(this).hasClass('extras')){
              $(this).find('.qtyExtra').each(function(){                    
                $(this).val(qtyval);
                var id = $(this).attr('id');
                var it = $('<input[data-id="'+id+'"]');
                $('<input[data-id="'+id+'"]').val(0); 
              });              
            }
          });
        }        
      });      
      //$('#cartform').submit();
    });
    $('.removeqty').click(function(e){
      e.preventDefault();      
      var $tr = $(this).closest('tr');
      var nexttr = $tr.next();
      var u = $tr.attr('data-u');
      $('.item-quantity', $(this).closest('tr')).val(0);
      var id = $('.item-quantity', $(this).closest('tr')).attr('id');
      var it = $('<input[data-id="'+id+'"]');
      $('<input[data-id="'+id+'"]').val(0);
      if($tr.hasClass('mainproduct')){
        var nexttr = $('tr[data-e="'+u+'"]');
        nexttr.each(function(){
          if($(this).hasClass('extras')){
            $(this).find('.qtyExtra').each(function(){                    
              $(this).val(0);
              var id = $(this).attr('id');
              var it = $('<input[data-id="'+id+'"]');
              $('<input[data-id="'+id+'"]').val(0); 
            });              
          }
        });
      }
      $('#cartform').submit();

    });
  });
</script>