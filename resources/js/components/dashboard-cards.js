export function renderDashboardCard(title, value, subtitle, icon, type = 'default') {
  const styles = {
    primary: {
      bg: 'bg-primary/10 text-primary',
      hover: 'group-hover:bg-primary group-hover:text-white',
      border: 'hover:border-primary/20',
      subtitleColor: 'text-green-600'
    },
    accent: {
      bg: 'bg-accent/10 text-accent-700',
      hover: 'group-hover:bg-accent group-hover:text-white',
      border: 'hover:border-accent/20',
      subtitleColor: 'text-gray-500'
    },
    default: {
      bg: 'bg-gray-100 text-gray-500',
      hover: 'group-hover:bg-gray-200',
      border: 'hover:border-gray-300',
      subtitleColor: 'text-gray-500'
    }
  };
  
  const style = styles[type] || styles.default;
  
  return `
    <div class="card p-6 bg-white border border-gray-100 flex items-center gap-4 group ${style.border} transition-colors">
      <div class="w-14 h-14 ${style.bg} rounded-2xl flex items-center justify-center ${style.hover} transition-colors">
        ${icon}
      </div>
      <div>
        <p class="text-sm text-gray-500 mb-1">${title}</p>
        <h3 class="text-2xl font-poppins font-bold text-foreground">${value}</h3>
        ${subtitle ? `<p class="text-xs ${style.subtitleColor} font-medium mt-1">${subtitle}</p>` : ''}
      </div>
    </div>
  `;
}
