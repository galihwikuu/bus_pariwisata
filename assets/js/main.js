// main.js — Janitra Surya Transportation
document.addEventListener('DOMContentLoaded', function () {

    // 1. Scroll Fade-in
    const fades = document.querySelectorAll('.fade-in');
    const obs = new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if(e.isIntersecting){
                const delay = e.target.dataset.delay || 0;
                setTimeout(function(){ e.target.classList.add('visible'); }, delay);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    fades.forEach(function(el){ obs.observe(el); });

    // 2. Counter animation
    function animCount(el, target, dur){
        let s=0; const step=target/(dur/16);
        const t=setInterval(function(){
            s+=step; if(s>=target){ el.textContent=target+(el.dataset.suffix||''); clearInterval(t); }
            else{ el.textContent=Math.floor(s)+(el.dataset.suffix||''); }
        },16);
    }
    const counters=document.querySelectorAll('[data-counter]');
    const cObs=new IntersectionObserver(function(entries){
        entries.forEach(function(e){
            if(e.isIntersecting){ animCount(e.target,parseInt(e.target.dataset.counter),1500); cObs.unobserve(e.target); }
        });
    },{threshold:0.5});
    counters.forEach(function(el){ cObs.observe(el); });

    // 3. Mobile nav toggle
    const tog = document.getElementById('navToggler');
    const menu = document.getElementById('navMenu');
    if(tog && menu){
        tog.addEventListener('click', function(){
            menu.classList.toggle('open');
        });
        // Close when clicking outside
        document.addEventListener('click', function(e){
            if(!tog.contains(e.target) && !menu.contains(e.target)){
                menu.classList.remove('open');
            }
        });
    }

    // 4. Form booking validation
    const form = document.getElementById('bookingForm');
    if(form){
        const tanggalInput = document.getElementById('tanggal');
        if(tanggalInput){ tanggalInput.min = new Date().toISOString().split('T')[0]; }

        form.addEventListener('submit', function(e){
            let valid = true;
            form.querySelectorAll('[required]').forEach(function(f){
                f.classList.remove('is-invalid');
                if(!f.value.trim()){ f.classList.add('is-invalid'); valid=false; }
            });
            const hp = document.getElementById('no_hp');
            if(hp && hp.value && !/^[0-9+\-\s]{8,15}$/.test(hp.value)){
                hp.classList.add('is-invalid'); valid=false;
            }
            if(tanggalInput && tanggalInput.value){
                const today=new Date(); today.setHours(0,0,0,0);
                if(new Date(tanggalInput.value)<today){ tanggalInput.classList.add('is-invalid'); valid=false; }
            }
            const jml=document.getElementById('jumlah_penumpang');
            if(jml && (parseInt(jml.value)<1||parseInt(jml.value)>50)){ jml.classList.add('is-invalid'); valid=false; }
            if(!valid){
                e.preventDefault();
                showToast('Harap lengkapi semua kolom dengan benar!','danger');
            } else {
                const btn=form.querySelector('button[type="submit"]');
                if(btn){ btn.innerHTML='<i class="fas fa-spinner fa-spin me-2"></i>Memproses...'; btn.disabled=true; }
            }
        });
    }

    // 5. Toast notification
    function showToast(msg, type){
        const existing=document.querySelector('.js-toast'); if(existing) existing.remove();
        const colors={success:'#10B981',danger:'#CC0000',warning:'#F59E0B'};
        const icons={success:'fa-check-circle',danger:'fa-exclamation-circle',warning:'fa-exclamation-triangle'};
        const t=document.createElement('div'); t.className='js-toast';
        t.style.cssText=`position:fixed;top:90px;right:22px;z-index:99999;background:white;border-radius:10px;padding:14px 22px;box-shadow:0 10px 40px rgba(0,0,0,0.15);display:flex;align-items:center;gap:12px;min-width:300px;border-left:4px solid ${colors[type]};animation:slideInR 0.4s ease;font-family:'Open Sans',sans-serif;`;
        t.innerHTML=`<i class="fas ${icons[type]}" style="color:${colors[type]};font-size:1.2rem;flex-shrink:0;"></i><span style="font-size:0.88rem;flex:1;">${msg}</span><button onclick="this.parentElement.remove()" style="border:none;background:none;cursor:pointer;color:#999;">✕</button>`;
        document.body.appendChild(t);
        setTimeout(function(){ if(t.parentElement) t.remove(); },4000);
    }

    // 6. Auto dismiss alerts
    document.querySelectorAll('.alert-auto').forEach(function(a){
        setTimeout(function(){ a.style.opacity='0'; a.style.transform='translateY(-10px)'; setTimeout(function(){ a.remove(); },500); },4500);
    });

    // Inject slideInR animation
    const s=document.createElement('style');
    s.textContent='@keyframes slideInR{from{opacity:0;transform:translateX(30px)}to{opacity:1;transform:translateX(0)}}';
    document.head.appendChild(s);

    // 7. Lightbox
    window.openLightbox = function(src, cap){
        let lb=document.getElementById('lightbox');
        if(!lb){
            lb=document.createElement('div'); lb.id='lightbox';
            lb.style.cssText='position:fixed;inset:0;background:rgba(0,0,0,0.93);z-index:99999;display:none;align-items:center;justify-content:center;padding:20px;';
            lb.innerHTML='<button onclick="closeLightbox()" style="position:absolute;top:20px;right:24px;background:rgba(255,255,255,0.15);border:none;color:white;width:44px;height:44px;border-radius:50%;cursor:pointer;font-size:1.2rem;">✕</button><div style="text-align:center;"><img id="lbImg" src="" style="max-width:90vw;max-height:80vh;object-fit:contain;border-radius:10px;"><div id="lbCap" style="color:white;margin-top:14px;font-size:0.88rem;font-family:Montserrat,sans-serif;font-weight:700;text-transform:uppercase;letter-spacing:1px;"></div></div>';
            lb.addEventListener('click',function(e){ if(e.target===lb) closeLightbox(); });
            document.body.appendChild(lb);
        }
        document.getElementById('lbImg').src=src;
        document.getElementById('lbCap').textContent=cap||'';
        lb.style.display='flex'; document.body.style.overflow='hidden';
    };

    window.closeLightbox = function(){
        const lb=document.getElementById('lightbox');
        if(lb){ lb.style.display='none'; document.body.style.overflow=''; }
    };

    document.addEventListener('keydown',function(e){ if(e.key==='Escape') closeLightbox(); });
});
