let gsapPromise = null;

export function useGsap() {
  if (!gsapPromise) {
    gsapPromise = (async () => {
      const gsapModule = await import('gsap');
      const gsap = gsapModule.default || gsapModule;
      // Dynamically import plugins
      const ScrollTriggerModule = await import('gsap/ScrollTrigger');
      const ScrollSmootherModule = await import('gsap/ScrollSmoother');
      const ScrollToPluginModule = await import('gsap/ScrollToPlugin');

      const ScrollTrigger = ScrollTriggerModule.ScrollTrigger || ScrollTriggerModule.default || ScrollTriggerModule;
      const ScrollSmoother = ScrollSmootherModule.ScrollSmoother || ScrollSmootherModule.default || ScrollSmootherModule;
      const ScrollToPlugin = ScrollToPluginModule.ScrollToPlugin || ScrollToPluginModule.default || ScrollToPluginModule;

      // Register plugins once
      if (gsap && ScrollTrigger) {
        try {
          gsap.registerPlugin(ScrollTrigger, ScrollSmoother, ScrollToPlugin);
        } catch (e) {
          // ignore re-register errors
        }
      }

      return { gsap, ScrollTrigger, ScrollSmoother, ScrollToPlugin };
    })();
  }
  return gsapPromise;
}
