export const generateTrack = (places) => {
    let tracks = [];
    if (places.length >= 2) {
        for (let i = 0; i < places.length; i++) {
            for (let j = i + 1; j < places.length; j++) {
                tracks.push({
                    source: places[i].place,
                    destination: places[j].place,
                    fastboat_source_id: places[i].place.id,
                    fastboat_destination_id: places[j].place.id,
                    price: 0,
                    arrival_time: "0:0",
                    departure_time: "0:0",
                    is_publish: 1,
                });
            }
        }
    }
    return tracks;
};
