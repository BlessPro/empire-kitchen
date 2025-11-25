<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <!-- Tailwind CDN (for quick prototype) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      // Optional: custom Tailwind config for brand color
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              brand: "#5A0562", // deep purple
            },
            borderRadius: {
              "3xl": "1.75rem",
            },
          },
        },
      };
    </script>
  </head>
  <body class="min-h-screen bg-[#f7f7fb] flex items-center justify-center p-4">
    <main
      class="w-full max-w-6xl bg-white rounded-3xl md:rounded-[2rem] shadow-sm border border-gray-100 px-6 py-8 md:px-14 md:py-12"
    >
      <div
        class="grid gap-10 md:gap-16 md:grid-cols-[minmax(0,1.15fr)_minmax(0,1fr)] items-start"
      >
        <!-- Left side: title & description -->
        <section class="max-w-xl">
          <h1
            class="text-[20px]  font-semibold tracking-tight text-gray-900 mb-3"
          >
            Email Notifications
          </h1>
          <p class="text-sm leading-relaxed text-gray-600 md:text-base">
            Stay informed with real-time updates delivered straight to your
            inbox. Customize notifications to keep track of what matters most.
          </p>
        </section>

        <!-- Right side: toggles -->
        <section class="space-y-8">
          <!-- Toggle row -->
          <div class="flex items-start gap-4">
            <!-- Switch (ON state) -->
            <button
              type="button"
              class="relative inline-flex items-center flex-shrink-0 w-16 h-10 transition rounded-full cursor-pointer bg-brand"
              aria-pressed="true"
            >
              <span
                class="inline-block w-8 h-8 transition transform translate-x-6 bg-white rounded-full shadow-md"
              ></span>
            </button>
            <!-- Text -->
            <div>
              <p class="text-sm font-medium text-gray-900">
                Enable all notifications
              </p>
              <p class="mt-1 text-xs text-gray-500 md:text-sm">
                Updates on everything going on in the system.
              </p>
            </div>
          </div>

          <!-- Toggle row -->
          <div class="flex items-start gap-4">
            <button
              type="button"
              class="relative inline-flex items-center flex-shrink-0 w-16 h-10 transition rounded-full cursor-pointer bg-brand"
              aria-pressed="true"
            >
              <span
                class="inline-block w-8 h-8 transition transform translate-x-6 bg-white rounded-full shadow-md"
              ></span>
            </button>
            <div>
              <p class="text-sm font-medium text-gray-900">Messages</p>
              <p class="mt-1 text-xs text-gray-500 md:text-sm">
                Receive messages on ongoing projects.
              </p>
            </div>
          </div>

          <!-- Toggle row -->
          <div class="flex items-start gap-4">
            <button
              type="button"
              class="relative inline-flex items-center flex-shrink-0 w-16 h-10 transition rounded-full cursor-pointer bg-brand"
              aria-pressed="true"
            >
              <span
                class="inline-block w-8 h-8 transition transform translate-x-6 bg-white rounded-full shadow-md"
              ></span>
            </button>
            <div>
              <p class="text-sm font-medium text-gray-900">
                Project Comments
              </p>
              <p class="mt-1 text-xs text-gray-500 md:text-sm">
                Receive comments on ongoing projects.
              </p>
            </div>
          </div>
        </section>
      </div>
    </main>
  </body>
</html>
