window.addEventListener("load", (event) => {
    for (var i = 0; i < Object.keys(parts).length; i++) {
        renderParts(i,parts,document.getElementById("partsBody"));
    }
});

function renderParts(index,parts,partsBody){
    const div = document.createElement("div");
    const id = document.createElement("h2");
    const partsInfo = document.createElement("h3");
    const name = document.createElement("p");
    const type = document.createElement("p");
    const brand = document.createElement("p");
    const modelNumber = document.createElement("p");
    const releasedDate = document.createElement("p");
    const description = document.createElement("p");
    const performanceScore = document.createElement("p");
    const marketPrice = document.createElement("p");
    const rsm = document.createElement("p");
    const powerConsumption = document.createElement("p");
    const dimensions = document.createElement("h3");
    const length = document.createElement("p");
    const width = document.createElement("p");
    const height = document.createElement("p");
    const lifespan = document.createElement("p");

    div.setAttribute("id", "computer_parts_"+(index+1));
    id.innerHTML = parts[index].id;
    partsInfo.innerHTML = "Parts Information";
    name.innerHTML = parts[index].name;
    type.innerHTML = parts[index].type;
    brand.innerHTML = parts[index].brand;
    modelNumber.innerHTML = parts[index].model_number;
    releasedDate.innerHTML = parts[index].release_date;
    description.innerHTML = parts[index].description;
    performanceScore.innerHTML = parts[index].performance_score;
    marketPrice.innerHTML = parts[index].market_price;
    rsm.innerHTML = parts[index].rsm;
    powerConsumption.innerHTML = parts[index].power_consumptionw;
    dimensions.innerHTML = "Dimensions (L x W x H)";
    length.innerHTML = parts[index].lengthm;
    width.innerHTML = parts[index].widthm;
    height.innerHTML = parts[index].heightm;
    lifespan.innerHTML = parts[index].lifespan;

    div.append(id);
    div.append(partsInfo);
    div.append(name);
    div.append(type);
    div.append(brand);
    div.append(modelNumber);
    div.append(releasedDate);
    div.append(description);
    div.append(performanceScore);
    div.append(marketPrice);
    div.append(rsm);
    div.append(powerConsumption);
    div.append(dimensions);
    div.append(length);
    div.append(width);
    div.append(height);
    div.append(lifespan);
    partsBody.append(div);
}