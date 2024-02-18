<?php for($i = 0;$i < count($parts);$i++): ?>
    <div class="col-12" id="partsBody">
        <div >
            <h2>ID : <?= $parts[$i]->getId() ?></h2>
            <h3>Parts Information : </h3>
            <p>name : <?= $parts[$i]? htmlspecialchars($parts[$i]->getName()) : '' ?></p>
            <p>type : <?= $parts[$i]? htmlspecialchars($parts[$i]->getType()) : '' ?></p>
            <p>brand : <?= $parts[$i]? htmlspecialchars($parts[$i]->getBrand()) : '' ?></p>
            <p>model number : <?= $parts[$i]? htmlspecialchars($parts[$i]->getModelNumber()) : '' ?></p>
            <p>released date : <?= $parts[$i]? htmlspecialchars($parts[$i]->getReleaseDate()) : '' ?></p>
            <p>description : <?= $parts[$i]? htmlspecialchars($parts[$i]->getDescription()) : '' ?></p>
            <p>performance score : <?= $parts[$i]? $parts[$i]->getPerformanceScore() : '' ?></p>
            <p>market price : <?= $parts[$i]? $parts[$i]->getMarketPrice() : '' ?></p>
            <p>rsm : <?= $parts[$i]? $parts[$i]->getRsm() : '' ?></p>
            <p>power consumption : <?= $parts[$i]? $parts[$i]->getPowerConsumptionW() : '' ?></p>
            <h3>Dimensions (L x W x H):</h3>
            <p>length : <?= $parts[$i] ? $parts[$i]->getLengthM() : '' ?></p>
            <p>width : <?= $parts[$i] ? $parts[$i]->getWidthM() : '' ?>" placeholder="Width (meters)</p>
            <p>height : <?= $parts[$i] ? $parts[$i]->getHeightM() : '' ?></p>
            <p>lifespan : <?= $parts[$i]? $parts[$i]->getLifespan() : '' ?></p>
        </div>
    </div>
<?php endfor; ?>