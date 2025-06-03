
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AKDN | Project's Green Building</title>

  @include('_layouts.partials.head')
@yield('css-section')
    @yield('js-section-top')

<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  @include('_layouts.partials.nav')

@include('_layouts.partials.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
                @yield('content')
            </div>
  <!-- /.content-wrapper -->

 @include('_layouts.partials.footer')
 @yield('js-section')
</div>
<!-- ./wrapper -->


</body>
</html>
