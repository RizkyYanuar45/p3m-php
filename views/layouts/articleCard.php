 <article class="group bg-white dark:bg-slate-900 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col">
     <div class="relative aspect-video overflow-hidden">
         <img class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-500" data-alt="<?= htmlspecialchars($title) ?>" src="<?= !empty($thumbnail) ? htmlspecialchars($thumbnail) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuA-4190uWCFsZrJfTsE9MooTSP09Cvo8achHDJzeM2h6b3HU6X4QtXYjErimRDE1IaP9sYUHAADLQAhv06ghE3uyRAyt9TUxA4weJLdDZYuCsXYg2UGWB8ZRZOlKo8-QcyybSyzAsojjvg8DRsZLdREtOM9SnMimYz1j6ya36U7Zzlq9g0cH7lbWB7F-pr6D4BLc50YBoUeoNJbakM8zAcTT0TFCeEGC8CxfCMsiN7c_tstvcJMRY3Zx1lAL7btRGT37bEqlNLstDU' ?>" />
         <div class="absolute top-4 left-4">
             <span class="px-3 py-1 bg-primary text-white text-xs font-bold uppercase tracking-wider rounded-md">
                 <?= str_replace('informasi_', '', htmlspecialchars($category)) ?>
             </span>
         </div>
     </div>
     <div class="p-6 flex flex-col flex-grow">
         <h3 class="text-xl font-bold mb-3 text-slate-900 dark:text-white line-clamp-2 leading-tight group-hover:text-primary transition-colors">
             <a href="/artikel/<?= htmlspecialchars($category) ?>/<?= htmlspecialchars($slug) ?>">
                 <?= htmlspecialchars($title) ?>
             </a>
         </h3>
         <div class="text-slate-600 dark:text-slate-400 text-sm line-clamp-3 mb-6 flex-grow">
             <?= strip_tags($content) ?>
         </div>
         <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-800">
             <div class="flex items-center gap-2">
                 <span class="material-symbols-outlined text-slate-400 text-xl">account_circle</span>
                 <span class="text-xs font-medium text-slate-700 dark:text-slate-300"><?= htmlspecialchars($author) ?></span>
             </div>
             <span class="text-xs text-slate-500"><?= date('d M Y', strtotime($published_date)) ?></span>
         </div>
     </div>
 </article>
