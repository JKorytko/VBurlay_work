//алгоритм vega

function vega() {
	
	var mins, maxs, minv, maxv, minl, maxl, mind, maxd, mind0, maxd0, a;
		
	mins = 0.00001;
	maxs = 0.01023;
	minv = 2.5;
	maxv = 100;
	minl = 0.1;
	maxl = 0.5;
	mind = 0.01;
	maxd = 0.1;
	mind0 = 0.2e-7;
	maxd0 = 2.5e-7;
	a = 10.12E-14;
	
//сгенерировать случайную популяцию

	var sublength;
	var inds, indv, indl, indd, indd0;
	
	sublength = length/2;
	
	inds= new Array(length);
	indv= new Array(length);
	indl= new Array(length);
	indd= new Array(length);
	indd0= new Array(length);
	

	for (i = 0; i < length; i++) {
        inds[i] = Math.random() * (maxs - mins) +mins;  //minmax
		indv[i] = Math.random() * (maxv - minv) +minv;
		indl[i] = Math.random() * (maxl - minl) +minl;
		indd[i] = Math.random() * (maxd - mind) +mind;
		indd0[i] = Math.random() * (maxd0 - mind0) +mind0;

    }
	
//цикл
	
	for (count = 0; count < limit; count++) {
	
//вычислить фитнес-функции для каждого критерия оптимизации

	var fitness, fitness1, fitness2, sum1=0, sum2=0;
	fitness = new Array(length);
	fitness1 = new Array(sublength);
	fitness2 = new Array(sublength);

	for (i = 0; i < sublength; i++) {
		fitness[i] = Math.sqrt(Math.pow(indd0[i],2)+a*((Math.PI*indd[i]*indl[i])/(inds[i]*indv[i])));
		sum1+=fitness[i];

	}
	
	for (i = sublength; i < length; i++) {	
		fitness[i] = 1/(inds[i]*indv[i]);
		sum2+=fitness[i];
				
	}
		
	var minfit1, minfit2, maxfit1, maxfit2, avgfit1, avgfit2;
	
	fitness1 = fitness.slice(0, sublength);
	fitness2 = fitness.slice(sublength, length);
	
	minfit1 = Math.min.apply(null, fitness1);
	minfit2 = Math.min.apply(null, fitness2);
	
	avgfit1 = sum1/sublength;
	avgfit2 = sum2/sublength;
	
	min1[count] = minfit1;
	min2[count] = minfit2;
	
	average1[count] = avgfit1;
	average2[count] = avgfit2;
			
	for (i = 0; i < sublength; i++) {
		if (fitness[i] == minfit1) {
			rs1 = inds[i]; rv1 = indv[i]; rl1 = indl[i]; rd1 = indd[i]; rd01 = indd0[i];
			break;
		}			
	}
	for (i = sublength; i < length; i++) {
		if (fitness[i] == minfit2) {
			rs2 = inds[i]; rv2 = indv[i]; rl2 = indl[i]; rd2 = indd[i]; rd02 = indd0[i];
			break;
		}			
	}

//выбрать особи для скрещивания, кроссовер, мутация

	var offsprings, offspringv, offspringl, offspringd, offspringd0;
	offsprings= new Array(length);
	offspringv= new Array(length);
	offspringl= new Array(length);
	offspringd= new Array(length);
	offspringd0= new Array(length);

for (i = 0; i < length; i += 2) {
	
	var rand1, rand2, mom, dad, factor;
	
	//турнирный отбор, отдельно для каждой субпопуляции
	
	rand1 = Math.floor(Math.random() * (sublength));
	rand2 = Math.floor(Math.random() * (sublength));
	
	if (fitness[rand1]<fitness[rand2]) mom = rand1; else mom = rand2;
	
	rand1 = Math.floor(Math.random() * (length-sublength)) + sublength;
	rand2 = Math.floor(Math.random() * (length-sublength)) + sublength;
	
	if (fitness[rand1]<fitness[rand2]) dad = rand1; else dad = rand2;
	
	//линейный кроссовер общий
	
	factor = Math.random();
	
	offsprings[i] = factor*inds[mom] + (1 - factor)*inds[dad];
	offspringv[i] = factor*indv[mom] + (1 - factor)*indv[dad];
	offspringl[i] = factor*indl[mom] + (1 - factor)*indl[dad];
	offspringd[i] = factor*indd[mom] + (1 - factor)*indd[dad];
	offspringd0[i] = factor*indd0[mom] + (1 - factor)*indd0[dad];
	
	offsprings[i+1] = factor*inds[dad] + (1 - factor)*inds[mom];
	offspringv[i+1] = factor*indv[dad] + (1 - factor)*indv[mom];
	offspringl[i+1] = factor*indl[dad] + (1 - factor)*indl[mom];
	offspringd[i+1] = factor*indd[dad] + (1 - factor)*indd[mom];
	offspringd0[i+1] = factor*indd0[dad] + (1 - factor)*indd0[mom];
	
}
	//мутация?

	var  m1;	
	
	for (i = 0; i < length; i++) {	
	m1 = Math.random();	
	if (m1 < mutate) 
		offsprings[i] = offsprings[i] + Math.random() * (maxs-mins)/10;
	if (offsprings[i] > maxs) offsprings[i] = maxs; else if (offsprings[i] < mins) offsprings[i] = mins;
	}
	for (i = 0; i < length; i++) {	
	m1 = Math.random();	
	if (m1 < mutate) 
		offspringv[i] = offspringv[i] + Math.random() *(maxv-minv)/10;	
	if (offspringv[i] > maxv) offspringv[i] = maxv; else if (offspringv[i] < minv) offsprings[i] = minv;	
	}
	for (i = 0; i < length; i++) {	
	m1 = Math.random();	
	if (m1 < mutate) 
		offspringl[i] = offspringl[i] - Math.random() *(maxl-minl)/10;	
	if (offspringl[i] > maxl) offspringl[i] = maxl; else if (offspringl[i] < minl) offspringl[i] = minl;	
	}
	for (i = 0; i < length; i++) {	
	m1 = Math.random();	
	if (m1 < mutate) 
		offspringd[i] = offspringd[i] - Math.random() *(maxd-mind)/10;	
	if (offspringd[i] > maxd) offspringd[i] = maxd; else if (offspringd[i] < mind) offspringd[i] = mind;	
	}
	for (i = 0; i < length; i++) {	
	m1 = Math.random();	
	if (m1 < mutate) 
		offspringd0[i] = offspringd0[i] - Math.random() *(maxd0-mind0)/10;	
	if (offspringd0[i] > maxd0) offspringd0[i] = maxd0; else if (offspringd0[i] < mind0) offspringd0[i] = mind0;	
	}

//замена старой популяции на новую
	
	for (i = 0; i < length; i++) {
		
		inds[i] = offsprings[i];
		indv[i] = offspringv[i];
		indl[i] = offspringl[i];
		indd[i] = offspringd[i];
		indd0[i] = offspringd0[i];
						
	}

}

}