<!DOCTYPE html>
<html>

<head>
    <title>Search Functionality Using jQuery</title>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#searchbox").keyup(function() {
                var filter = $(this).val(),
                    count = 0;
                $(".products li").each(function() {
                    if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                        $(this).fadeOut();
                    } else {
                        $(this).show();
                        count++;
                    }
                });
                var numberItems = count;
                $("#result-count").text("Number of Results = " + count);
            });
        });
    </script>
</head>

<body>
    <form id="live-search" action="" class="search-form" method="post">
        <label>Search product</label>
        <input type="text" class="text-input" id="searchbox" value="" />
        <div id="result-count"></div>
    </form>
    <ol class="products">
        <li>Product1</li>
        <li>Product2</li>
        <li>Product3</li>
        <li>product1</li>
        <li>product2</li>
        <li>product3</li>
        <li>product2</li>
        <li>product1</li>
        <li>Product3</li>
        <li>Product4</li>
        <li>Product5</li>
    </ol>




</body>

</html>
