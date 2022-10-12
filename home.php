<?php
session_start();
include("header.php");
?>
<html>
  <head>
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.0.3/howler.min.js"
    ></script>
    <title>No title</title>
    <script
      type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.0.3/howler.min.js"
    ></script>
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    />
    <link
      href="http://fonts.googleapis.com/css?family=Varela+Round"
      rel="stylesheet"
      type="text/css"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
      @import url('https://fonts.googleapis.com/css?family=Nunito');
      @import url('https://fonts.googleapis.com/css?family=Poiret+One');

      body,
      html {
        height: 80%;
        background-repeat: no-repeat;
        background: black;
        position: relative;
      }

      #particles-js {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: 50% 50%;
        position: relative;
        top: 0px;
        z-index: 1;
      }

      h1 {
        text-shadow: 0 0 25px rgba(254, 254, 255, 0.85);
        width: 100%;
        color: rgb(10, 224, 21);
        padding-top: 100px;
      }

      footer {
        margin: 20%;
      }

      #a {
        onmousedown: stop;
        animation-name: rotate;
        animation-duration: 5s;
        animation-play-state: running;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
        opacity: 1;
        filter: alpha(opacity=50);
      }

      img:hover {
        opacity: 1;
        filter: alpha(opacity=100);
      }

      @keyframes rotate {
        10% {
          transform: rotateY(36deg);
        }
        20% {
          transform: rotateY(72deg);
        }
        30% {
          transform: rotateY(108deg);
        }
        40% {
          transform: rotateY(144deg);
        }
        50% {
          transform: rotateY(180deg);
        }
        60% {
          transform: rotateY(216deg);
        }
        70% {
          transform: rotateY(252deg);
        }
        80% {
          transform: rotateY(288deg);
        }
        90% {
          transform: rotateY(324deg);
        }
        100% {
          transform: rotateY(360deg);
        }
      }
    </style>
  </head>
  <!-- Body -->
  <body>
  <center>
		<!-- <h1 >“Death is like the wind – always by my side.”</h1> -->
		<img src="https://i.imgur.com/H7mdomQ.jpeg" height="300" width="600">
    <h5 style="color: white;">Họ và Tên: Quyền Hồng Sơn</h5><br>
    <h5 style="color: white;">Mã Sinh Viên: AT150547</h5>
	</center>
        <div id="particles-js">
          <canvas
            class="particles-js-canvas-el"
            style="width: 100%; height: 100%"
            width="1365"
            height="949"
          ></canvas>
        </div> </b
    ></b>
    <div align="center" class="a">
      <font color="white"></font>
    </div>
    <font color="white"
      ><br />
      <div align="center"></div>
      <br />
    </font>
  </body>
</html>
<script type="text/javascript">
  $.getScript(
    'https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js',
    function () {
      particlesJS('particles-js', {
        particles: {
          number: {
            value: 80,
            density: {
              enable: true,
              value_area: 800,
            },
          },
          color: {
            value: '#ffffff',
          },
          shape: {
            type: 'circle',
            stroke: {
              width: 0,
              color: '#000000',
            },
            polygon: {
              nb_sides: 5,
            },
            image: {
              width: 100,
              height: 100,
            },
          },
          opacity: {
            value: 0.5,
            random: false,
            anim: {
              enable: false,
              speed: 1,
              opacity_min: 0.1,
              sync: false,
            },
          },
          size: {
            value: 5,
            random: true,
            anim: {
              enable: false,
              speed: 40,
              size_min: 0.1,
              sync: false,
            },
          },
          line_linked: {
            enable: true,
            distance: 150,
            color: '#ffffff',
            opacity: 0.4,
            width: 1,
          },
          move: {
            enable: true,
            speed: 6,
            direction: 'none',
            random: false,
            straight: false,
            out_mode: 'out',
            attract: {
              enable: false,
              rotateX: 600,
              rotateY: 1200,
            },
          },
        },
        interactivity: {
          detect_on: 'canvas',
          events: {
            onhover: {
              enable: true,
              mode: 'repulse',
            },
            onclick: {
              enable: true,
              mode: 'push',
            },
            resize: true,
          },
          modes: {
            grab: {
              distance: 400,
              line_linked: {
                opacity: 1,
              },
            },
            bubble: {
              distance: 400,
              size: 40,
              duration: 2,
              opacity: 8,
              speed: 3,
            },
            repulse: {
              distance: 200,
            },
            push: {
              particles_nb: 4,
            },
            remove: {
              particles_nb: 2,
            },
          },
        },
        retina_detect: true,
        config_demo: {
          hide_card: false,
          background_color: '#b61924',
          background_image: '',
          background_position: '50% 50%',
          background_repeat: 'no-repeat',
          background_size: 'cover',
        },
      });
    }
  );
</script>

<?php

include("footer.php");
?>