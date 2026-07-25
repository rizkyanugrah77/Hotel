export function renderBookingStepper(currentStep) {
  const steps = [
    { num: 1, title: 'Select Room' },
    { num: 2, title: 'Guest Details' },
    { num: 3, title: 'Payment' }
  ];
  
  const progressPercent = currentStep === 1 ? 0 : currentStep === 2 ? 50 : 100;
  
  return `
    <div class="mb-12">
      <div class="flex items-center justify-between max-w-2xl mx-auto relative">
        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-gray-200 rounded-full -z-10"></div>
        <div class="absolute left-0 top-1/2 -translate-y-1/2 w-[${progressPercent}%] h-1 bg-primary rounded-full -z-10 transition-all duration-500"></div>
        
        ${steps.map(step => {
          if (step.num < currentStep) {
            return `
              <div class="flex flex-col items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shadow-red"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg></div>
                <span class="text-xs font-semibold text-primary">${step.title}</span>
              </div>
            `;
          } else if (step.num === currentStep) {
            return `
              <div class="flex flex-col items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shadow-red ring-4 ring-primary/20">${step.num}</div>
                <span class="text-xs font-semibold text-primary">${step.title}</span>
              </div>
            `;
          } else {
            return `
              <div class="flex flex-col items-center gap-2">
                <div class="w-10 h-10 rounded-full bg-white border-2 border-gray-300 text-gray-400 flex items-center justify-center font-bold">${step.num}</div>
                <span class="text-xs font-medium text-gray-400">${step.title}</span>
              </div>
            `;
          }
        }).join('')}
      </div>
    </div>
  `;
}
